<?php

namespace App;

use App\Mail\DocumentReviewReminder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;

class DocumentReviewReminderService
{
    private $connection;
    private $driver;
    private $nextReviewDate;
    private $today;
    private $reminderTrackingAvailable;

    public function __construct()
    {
        $this->connection = DB::connection('mysql3');
        $this->driver = $this->connection->getDriverName();
        $this->nextReviewDate = DocumentReviewCycle::nextReviewDateExpression($this->driver);
        $this->today = $this->driver === 'sqlite' ? "DATE('now')" : 'CURDATE()';
        $this->reminderTrackingAvailable = Schema::connection('mysql3')->hasTable('document_review_reminder_tracking');
    }

    public function preview()
    {
        $groups = $this->eligibleOwnerGroups();

        return [
            'documents' => array_sum(array_map(function ($group) {
                return count($group['documents']);
            }, $groups)),
            'owners' => count($groups),
            'without_owner' => $this->activeUnassignedCount(),
            'tracking_available' => $this->reminderTrackingAvailable,
        ];
    }

    public function send()
    {
        if (!$this->reminderTrackingAvailable) {
            throw new \RuntimeException('Annual review reminder tracking is unavailable until its additive migration has been applied.');
        }
        $groups = $this->eligibleOwnerGroups();
        $result = [
            'owners' => count($groups),
            'documents' => array_sum(array_map(function ($group) {
                return count($group['documents']);
            }, $groups)),
            'emails_sent' => 0,
            'failed' => 0,
            'failures' => [],
        ];

        foreach ($groups as $ownerId => $group) {
            if (!$group['email'] || !filter_var($group['email'], FILTER_VALIDATE_EMAIL)) {
                $result['failed']++;
                $result['failures'][] = $this->failureLabel($group, 'No valid email address is registered.');
                continue;
            }

            $claimedDocuments = $this->claimDocuments($ownerId, $group['documents']);
            if (!$claimedDocuments) {
                continue;
            }

            try {
                Mail::to($group['email'])->send(new DocumentReviewReminder($group, $claimedDocuments));
                $result['emails_sent']++;
            } catch (\Throwable $e) {
                $this->releaseClaims($claimedDocuments);
                $result['failed']++;
                $result['failures'][] = $this->failureLabel($group, 'Email could not be sent.');
                \Log::error('Annual review reminder failed for owner '.$ownerId.' ('.get_class($e).').');
            }
        }

        return $result;
    }

    private function eligibleOwnerGroups()
    {
        $groups = [];
        $this->eligibleDocumentsQuery()->chunk(200, function ($documents) use (&$groups) {
            $previousCycles = [];
            if ($this->reminderTrackingAvailable && $documents->count()) {
                $documentIds = $documents->pluck('DOCID')->all();
                foreach ($this->connection->table('document_review_reminder_tracking')
                    ->whereIn('DOCID', $documentIds)->get() as $tracking) {
                    $key = $tracking->DOCID."\0".$tracking->DOCREV;
                    $previousCycles[$key] = $tracking->REMINDER_CYCLE;
                }
            }

            foreach ($documents as $document) {
                $cycleKey = DocumentReviewCycle::cycleKey(
                    $document->REVISION_DATE,
                    $document->REVIEWED_AT,
                    $document->DOCREV
                );
                $documentKey = $document->DOCID."\0".$document->DOCREV;
                $previousCycle = isset($previousCycles[$documentKey]) ? $previousCycles[$documentKey] : null;
                if ($cycleKey === null || ($this->reminderTrackingAvailable && $previousCycle === $cycleKey)) {
                    continue;
                }

                $ownerId = (int) $document->OWNER_ID;
                if (!isset($groups[$ownerId])) {
                    $groups[$ownerId] = [
                        'id' => $ownerId,
                        'name' => trim((string) $document->OWNER_NAME),
                        'email' => trim((string) $document->OWNER_EMAIL),
                        'documents' => [],
                    ];
                }
                $document->REMINDER_CYCLE_KEY = $cycleKey;
                $document->PREVIOUS_REMINDER_CYCLE = $previousCycle;
                $document->REVISION_LABEL = $this->revisionLabel($document->DOCREV);
                $document->REVISION_DATE_LABEL = $this->formatDate(
                    $document->EFFECTIVE_REVISION_DATE
                );
                $document->NEXT_REVIEW_DATE_LABEL = $this->formatDate($document->NEXT_REVIEW_DATE);
                $groups[$ownerId]['documents'][] = $document;
            }
        });

        return $groups;
    }

    private function eligibleDocumentsQuery()
    {
        $query = $this->connection->table('masterlist')
            ->join('users', 'users.id', '=', 'masterlist.OWNER_ID')
            ->whereIn('masterlist.CATID', ['SOP', 'WI'])
            ->where('masterlist.DOCSTATUS', 'Active')
            ->whereNotNull('masterlist.OWNER_ID')
            ->whereRaw($this->nextReviewDate.' IS NOT NULL')
            ->whereRaw($this->nextReviewDate.' <= '.$this->today)
            ->select('masterlist.*', 'users.email as OWNER_EMAIL', 'users.name as OWNER_NAME')
            ->selectRaw(DocumentReviewCycle::revisionDateExpression($this->driver).' AS EFFECTIVE_REVISION_DATE')
            ->selectRaw($this->nextReviewDate.' AS NEXT_REVIEW_DATE')
            ->orderBy('masterlist.OWNER_ID')
            ->orderBy('masterlist.DOCID')
            ->orderBy('masterlist.DOCREV');

        return $query;
    }

    private function activeUnassignedCount()
    {
        return $this->connection->table('masterlist')
            ->whereIn('CATID', ['SOP', 'WI'])
            ->where('DOCSTATUS', 'Active')
            ->whereNull('OWNER_ID')
            ->count();
    }

    private function claimDocuments($ownerId, array $documents)
    {
        $claimed = [];
        foreach ($documents as $document) {
            $currentDocument = $this->connection->table('masterlist')
                ->where('DOCID', $document->DOCID)
                ->where('DOCREV', $document->DOCREV)
                ->whereIn('CATID', ['SOP', 'WI'])
                ->where('DOCSTATUS', 'Active')
                ->where('OWNER_ID', $ownerId)
                ->whereRaw($this->nextReviewDate.' <= '.$this->today)
                ->where(function ($current) use ($document) {
                    $this->whereSameValue($current, 'REVISION_DATE', $document->REVISION_DATE);
                    $this->whereSameValue($current, 'REVIEWED_AT', $document->REVIEWED_AT);
                })->exists();

            if (!$currentDocument) {
                continue;
            }

            $tracking = $this->connection->table('document_review_reminder_tracking');
            $update = $tracking->where('DOCID', $document->DOCID)
                ->where('DOCREV', $document->DOCREV);
            $this->whereSameValue($update, 'REMINDER_CYCLE', $document->PREVIOUS_REMINDER_CYCLE);
            if ($update->update(['REMINDER_CYCLE' => $document->REMINDER_CYCLE_KEY]) === 1) {
                $claimed[] = $document;
                continue;
            }

            if ($document->PREVIOUS_REMINDER_CYCLE !== null) {
                continue;
            }

            try {
                $tracking->insert([
                    'DOCID' => $document->DOCID,
                    'DOCREV' => $document->DOCREV,
                    'REMINDER_CYCLE' => $document->REMINDER_CYCLE_KEY,
                ]);
                $claimed[] = $document;
            } catch (QueryException $e) {
                if ($e->getCode() !== '23000') {
                    throw $e;
                }
            }
        }

        return $claimed;
    }

    private function releaseClaims(array $documents)
    {
        foreach ($documents as $document) {
            $query = $this->connection->table('document_review_reminder_tracking')
                ->where('DOCID', $document->DOCID)
                ->where('DOCREV', $document->DOCREV)
                ->where('REMINDER_CYCLE', $document->REMINDER_CYCLE_KEY);
            if (!$query->update(['REMINDER_CYCLE' => $document->PREVIOUS_REMINDER_CYCLE])) {
                \Log::error('Failed to release annual review reminder claim for document '.$document->DOCID.'.');
            }
        }
    }

    private function whereSameValue($query, $column, $value)
    {
        if ($value === null) {
            $query->whereNull($column);
        } else {
            $query->where($column, $value);
        }
    }

    private function failureLabel(array $group, $reason)
    {
        return [
            'owner' => $group['name'] ?: 'User '.$group['id'],
            'email' => $group['email'] ?: 'No email address',
            'reason' => $reason,
        ];
    }

    private function revisionLabel($docrev)
    {
        if (preg_match('/^(.*?)\s*\(\d{2}[.-]\d{2}[.-]\d{4}\)$/', trim((string) $docrev), $matches)) {
            $revision = trim($matches[1]);
        } else {
            $revision = trim((string) $docrev);
        }

        return stripos($revision, 'rev') === 0 ? $revision : 'Rev '.$revision;
    }

    private function formatDate($date)
    {
        if ($date === null || $date === '') {
            return '';
        }

        return \Carbon\Carbon::parse($date)->format('d-m-Y');
    }
}
