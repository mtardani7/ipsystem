<?php

namespace App\Http\Controllers;

use App\Division;
use App\DocumentReviewCycle;
use App\DocumentReviewReminderService;
use App\Masterlist;
use App\User;
use App\UserLevel;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DocumentOwnerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $requiredColumns = ['OWNER_ID', 'REVISION_DATE', 'REVIEWED', 'REVIEWED_BY', 'REVIEWED_AT', 'REVIEW_NOTE'];
        $missingColumns = [];
        foreach ($requiredColumns as $column) {
            if (!Schema::connection('mysql3')->hasColumn('masterlist', $column)) {
                $missingColumns[] = $column;
            }
        }
        $reminderTrackingAvailable = Schema::connection('mysql3')->hasTable('document_review_reminder_tracking');

        $canManageOwner = $this->canManageOwner();
        if ($missingColumns) {
            return view('master.document_owner', compact('missingColumns', 'canManageOwner', 'reminderTrackingAvailable'));
        }

        $currentUserId = Auth::user()->id;
        $divisions = Division::orderBy('DIVID')->get();
        $ownerUsers = $canManageOwner ? User::orderBy('username')->get() : collect();
        $category = strtoupper((string) $request->input('category', 'ALL'));
        if (!in_array($category, ['ALL', 'SOP', 'WI'], true)) {
            $category = 'ALL';
        }
        $division = (string) $request->input('division', '');
        $owner = (string) $request->input('owner', '');
        $status = strtoupper((string) $request->input('status', 'ALL'));
        if (!in_array($status, ['ALL', 'NOT_ASSIGNED', 'NOT_SET', 'NOT_DUE', 'OK', 'NOK', 'NEEDS_REVIEW'], true)) {
            $status = 'ALL';
        }
        $documentStatus = strtoupper((string) $request->input('document_status', 'ACTIVE'));
        if (!in_array($documentStatus, ['ALL', 'ACTIVE', 'OBSOLETE'], true)) {
            $documentStatus = 'ACTIVE';
        }
        $needReview = $request->input('need_review') === '1';
        $myDocuments = $canManageOwner && $request->input('my_documents') === '1';
        $search = trim((string) $request->input('search', ''));
        $hasActiveFilters = $division !== '' || $category !== 'ALL' || $owner !== ''
            || $status !== 'ALL' || $documentStatus !== 'ACTIVE' || $needReview || $myDocuments || $search !== '';

        $documentScope = Masterlist::whereIn('CATID', ['SOP', 'WI']);
        if (!$canManageOwner) {
            $documentScope->where('OWNER_ID', $currentUserId);
        } elseif ($myDocuments) {
            $documentScope->where('OWNER_ID', $currentUserId);
        }

        $query = (clone $documentScope)->with('owner');
        if ($division !== '') {
            $query->where('DIVID', $division);
        }
        if ($category !== 'ALL') {
            $query->where('CATID', $category);
        }
        if ($documentStatus !== 'ALL') {
            $query->where('DOCSTATUS', $documentStatus === 'ACTIVE' ? 'Active' : 'Obsolete');
        }
        if ($owner === 'unassigned') {
            $query->whereNull('OWNER_ID');
        } elseif ($owner !== '' && ctype_digit($owner)) {
            $query->where('OWNER_ID', (int) $owner);
        }
        if ($search !== '') {
            $query->where(function ($searchQuery) use ($search) {
                $searchQuery->where('DOCID', 'like', '%'.$search.'%')
                    ->orWhere('DOCDESC', 'like', '%'.$search.'%');
            });
        }

        $summaryQuery = clone $documentScope;
        $activeQuery = clone $summaryQuery;
        $activeQuery->where('DOCSTATUS', 'Active');
        $reviewDueQuery = clone $activeQuery;
        $reviewDueQuery->whereNotNull('OWNER_ID')
            ->whereRaw($this->annualReviewDueExpression());
        $summary = [
            'active' => (clone $activeQuery)->count(),
            'without_owner' => (clone $activeQuery)->whereNull('OWNER_ID')->count(),
            'review_needed' => (clone $reviewDueQuery)->count(),
            'review_completed' => (clone $summaryQuery)->whereIn('REVIEWED', ['OK', 'NOK'])
                ->whereRaw(DocumentReviewCycle::reviewedForCurrentRevisionExpression(DB::connection('mysql3')->getDriverName()))->count(),
        ];

        $documentsQuery = clone $query;
        if ($status === 'NOT_ASSIGNED') {
            $documentsQuery->whereNull('OWNER_ID');
        } elseif ($status === 'NOT_SET') {
            $documentsQuery->whereRaw('('.DocumentReviewCycle::revisionDateExpression(DB::connection('mysql3')->getDriverName()).') IS NULL')
                ->whereNull('REVIEWED_AT');
        } elseif ($status === 'NOT_DUE') {
            $documentsQuery->whereRaw('('.$this->nextReviewDateExpression().') IS NOT NULL')
                ->whereRaw('('.$this->nextReviewDateExpression().') > '.($this->isSqlite() ? "DATE('now')" : 'CURDATE()'));
        } elseif (in_array($status, ['OK', 'NOK'], true)) {
            $documentsQuery->where('REVIEWED', $status)
                ->whereRaw(DocumentReviewCycle::reviewedForCurrentRevisionExpression(DB::connection('mysql3')->getDriverName()))
                ->whereRaw('('.$this->nextReviewDateExpression().') > '.($this->isSqlite() ? "DATE('now')" : 'CURDATE()'));
        } elseif ($status === 'NEEDS_REVIEW') {
            $documentsQuery->where('DOCSTATUS', 'Active')
                ->whereNotNull('OWNER_ID')
                ->whereRaw($this->annualReviewDueExpression());
        }
        if ($needReview) {
            $documentsQuery->where('DOCSTATUS', 'Active')
                ->whereNotNull('OWNER_ID')
                ->whereRaw($this->annualReviewDueExpression());
        }

        $documents = $documentsQuery
            ->select('masterlist.*')
            ->selectRaw(
                'CASE WHEN DOCSTATUS = ? AND OWNER_ID IS NOT NULL AND '.$this->annualReviewDueExpression().' THEN 1 ELSE 0 END AS ANNUAL_REVIEW_DUE',
                ['Active']
            )
            ->selectRaw($this->nextReviewDateExpression().' AS NEXT_REVIEW_DATE')
            ->selectRaw(DocumentReviewCycle::revisionDateExpression(DB::connection('mysql3')->getDriverName()).' AS EFFECTIVE_REVISION_DATE')
            ->selectRaw(DocumentReviewCycle::reviewedForCurrentRevisionExpression(DB::connection('mysql3')->getDriverName()).' AS REVIEWED_FOR_CURRENT_REVISION')
            ->orderBy('DIVID')->orderBy('CATID')->orderBy('DOCID')->orderBy('DOCREV')
            ->paginate(25, ['*'], 'documents_page')
            ->appends($request->query());

        if ($canManageOwner) {
            $ownerOptions = $ownerUsers;
        } else {
            $ownerOptions = collect();
            $owner = '';
        }

        return view('master.document_owner', compact(
            'missingColumns', 'canManageOwner', 'currentUserId', 'divisions', 'ownerUsers', 'ownerOptions',
            'category', 'division', 'owner', 'status', 'documentStatus', 'needReview', 'search', 'summary', 'documents',
            'myDocuments', 'hasActiveFilters', 'reminderTrackingAvailable'
        ));
    }

    public function previewReminders()
    {
        $this->authorizeReminderSending();

        return response()->json(app(DocumentReviewReminderService::class)->preview());
    }

    public function sendReminders()
    {
        $this->authorizeReminderSending();
        $this->requireReminderTracking();

        $result = app(DocumentReviewReminderService::class)->send();

        return redirect()->route('document_owner')->with('reminder_result', $result);
    }

    private function authorizeReminderSending()
    {
        if (!$this->canManageOwner()) {
            abort(403, 'Only superusers may send annual review reminders.');
        }
    }

    private function requireReminderTracking()
    {
        if (!Schema::connection('mysql3')->hasTable('document_review_reminder_tracking')) {
            abort(503, 'Annual review reminder tracking is unavailable until its additive migration has been applied.');
        }
    }

    public function bulkUpdate(Request $request)
    {
        if (!$this->canManageOwner()) {
            abort(403, 'Only superusers may manage SOP/WI owners and revision dates.');
        }

        $action = $request->input('bulk_action');
        try {
            $documents = $this->selectedDocuments($request->input('selected_documents'));

            if ($action === 'owner') {
                $this->validateOwnerDocumentSelection($documents);
                $ownerId = $this->validatedNullableOwnerId($request->input('owner_id'));
                $this->updateOwnerDocuments($documents, $ownerId);
                return redirect()->back()->with('success', count($documents).' documents updated successfully.');
            }

            if ($action === 'revision_date') {
                $revisionDate = $request->input('revision_date');
                if (!is_string($revisionDate) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $revisionDate)) {
                    throw new \InvalidArgumentException('Enter a valid revision date.');
                }
                $dateParts = explode('-', $revisionDate);
                if (!checkdate((int) $dateParts[1], (int) $dateParts[2], (int) $dateParts[0])) {
                    throw new \InvalidArgumentException('Enter a valid revision date.');
                }
                $this->updateSelectedDocuments($documents, ['REVISION_DATE' => $revisionDate]);
                return redirect()->back()->with('success', count($documents).' revision date(s) saved.');
            }

            throw new \InvalidArgumentException('The requested bulk action is invalid.');
        } catch (\InvalidArgumentException $e) {
            if ($action === 'owner') {
                return redirect()->back()->with('data', 'Owner update failed. No documents were changed.');
            }
            return redirect()->back()->with('data', $e->getMessage())->withInput();
        } catch (\Exception $e) {
            if ($action === 'owner') {
                \Log::error('Bulk document owner update failed: '.$e->getMessage());
                return redirect()->back()->with('data', 'Owner update failed. Please verify document owners before retrying.');
            }
            return redirect()->back()->with('data', $e->getMessage());
        }
    }

    public function updateOwner(Request $request)
    {
        if (!$this->canManageOwner()) {
            abort(403, 'Only superusers may manage SOP/WI owners.');
        }

        try {
            $documents = $this->selectedDocuments([
                base64_encode(json_encode([
                    $request->input('document_id'),
                    $request->input('document_revision'),
                ])),
            ]);
            $ownerId = $this->validatedNullableOwnerId($request->input('owner_id'));
            $this->validateOwnerDocumentSelection($documents);
            $this->updateOwnerDocuments($documents, $ownerId);

            if ($request->expectsJson()) {
                $owner = $ownerId === null ? null : User::find($ownerId);
                return response()->json([
                    'message' => 'Owner updated successfully.',
                    'owner_id' => $ownerId,
                    'owner_name' => $owner ? ($owner->name ?: $owner->username) : null,
                ]);
            }
            return redirect()->back()->with('success', 'Document owner updated successfully.');
        } catch (\InvalidArgumentException $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Owner update failed. No documents were changed.'], 422);
            }
            return redirect()->back()->with('data', 'Owner update failed. No documents were changed.');
        } catch (\Exception $e) {
            \Log::error('Single document owner update failed: '.$e->getMessage());
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Owner update failed. Please verify the document owner before retrying.'], 500);
            }
            return redirect()->back()->with('data', 'Owner update failed. Please verify the document owner before retrying.');
        }
    }

    public function submitReview(Request $request)
    {
        $docid = $request->input('document_id');
        $docrev = $request->input('document_revision');
        $reviewStatusInput = $request->input('review_status');
        $reviewStatus = is_string($reviewStatusInput) ? strtoupper(trim($reviewStatusInput)) : '';
        $reviewNote = $request->input('review_note', '');

        if (!is_string($docid) || $docid === '' || !is_string($docrev) || $docrev === ''
            || !in_array($reviewStatus, ['OK', 'NOK'], true) || !is_string($reviewNote)
            || ($reviewStatus === 'NOK' && trim($reviewNote) === '')) {
            return response()->json(['message' => 'Enter a valid review result and note.'], 422);
        }

        $document = Masterlist::where('DOCID', $docid)
            ->where('DOCREV', $docrev)
            ->first();

        if (!$document) {
            abort(404, 'Document not found.');
        }

        if (!in_array($document->CATID, ['SOP', 'WI'], true) || $document->DOCSTATUS !== 'Active') {
            abort(403, 'Only active SOP/WI documents can be reviewed.');
        }
        if ($document->OWNER_ID === null || (int) $document->OWNER_ID !== (int) Auth::user()->id) {
            abort(403, 'Only the assigned Document Owner may review this document.');
        }
        try {
            if (!DocumentReviewCycle::isDue($document->REVISION_DATE, $document->REVIEWED_AT, null, $document->DOCREV)) {
                return response()->json(['message' => 'Document is not yet due for annual review.'], 422);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'The document review cycle contains an invalid date.'], 422);
        }

        $reviewUpdate = DB::connection('mysql3')->table('masterlist')
            ->where('DOCID', $docid)
            ->where('DOCREV', $docrev)
            ->whereIn('CATID', ['SOP', 'WI'])
            ->where('DOCSTATUS', 'Active')
            ->where('OWNER_ID', Auth::user()->id)
            ->whereRaw($this->annualReviewDueExpression());
        if ($document->REVISION_DATE !== null) {
            $reviewUpdate->where('REVISION_DATE', $document->REVISION_DATE);
        } else {
            $reviewUpdate->whereNull('REVISION_DATE');
        }
        if ($document->REVIEWED_AT === null) {
            $reviewUpdate->whereNull('REVIEWED_AT');
        } else {
            $reviewUpdate->where('REVIEWED_AT', $document->REVIEWED_AT);
        }
        $updated = $reviewUpdate->update([
            'REVIEWED' => $reviewStatus,
            'REVIEWED_BY' => Auth::user()->id,
            'REVIEWED_AT' => DB::raw('CURRENT_TIMESTAMP'),
            'REVIEW_NOTE' => trim($reviewNote) === '' ? null : trim($reviewNote),
        ]);

        if ($updated === 0) {
            return response()->json(['message' => 'The document changed before the review could be saved. Please reload and try again.'], 409);
        }

        $response = ['message' => 'Document reviewed successfully.'];
        if ($reviewStatus === 'NOK') {
            session()->put('document_review_request_context', [
                'document_id' => $document->DOCID,
                'document_revision' => $document->DOCREV,
                'owner_id' => (int) $document->OWNER_ID,
            ]);
            session()->flash('document_review_notice', 'Document reviewed successfully. Please create the existing request form for this NOK review.');
            $response['request_url'] = route('create_req');
        } else {
            session()->forget('document_review_request_context');
        }

        return response()->json($response);
    }

    private function selectedDocuments($selectedIds)
    {
        if (!is_array($selectedIds) || count($selectedIds) === 0 || count($selectedIds) > 100) {
            throw new \InvalidArgumentException('Select between 1 and 100 SOP/WI documents.');
        }

        $documents = [];
        foreach ($selectedIds as $selectedDocument) {
            if (!is_string($selectedDocument)) {
                throw new \InvalidArgumentException('The selected document list is invalid.');
            }
            $decoded = base64_decode($selectedDocument, true);
            $documentKey = $decoded === false ? null : json_decode($decoded, true);
            if (!is_array($documentKey) || count($documentKey) !== 2
                || !is_string($documentKey[0]) || $documentKey[0] === ''
                || !is_string($documentKey[1]) || $documentKey[1] === '') {
                throw new \InvalidArgumentException('The selected document list is invalid.');
            }
            $documents[] = ['DOCID' => $documentKey[0], 'DOCREV' => $documentKey[1]];
        }

        $identities = array_map(function ($document) {
            return json_encode([$document['DOCID'], $document['DOCREV']]);
        }, $documents);
        if (count(array_unique($identities)) !== count($documents)) {
            throw new \InvalidArgumentException('The selected document list contains duplicates.');
        }

        return $documents;
    }

    private function updateSelectedDocuments(array $documents, array $values, $reviewOnly = false)
    {
        DB::connection('mysql3')->transaction(function () use ($documents, $values, $reviewOnly) {
            $query = $this->selectedDocumentsQuery($documents)->lockForUpdate();

            if ($reviewOnly) {
                $query->where('DOCSTATUS', 'Active')
                    ->whereNotNull('REVISION_DATE')
                    ->whereRaw('DATE_ADD(REVISION_DATE, INTERVAL 1 YEAR) <= CURDATE()');
            }

            if (count($query->get(['DOCID', 'DOCREV'])) !== count($documents)) {
                $message = $reviewOnly
                    ? 'A selected document is missing, not SOP/WI, inactive, or not due for review. No changes were saved.'
                    : 'A selected document is missing or is not SOP/WI. No changes were saved.';
                throw new \InvalidArgumentException($message);
            }

            $query->update($values);
        });
    }

    private function validateOwnerDocumentSelection(array $documents)
    {
        $matches = $this->selectedDocumentsQuery($documents)->get(['DOCID', 'DOCREV']);
        if (count($matches) !== count($documents)) {
            throw new \InvalidArgumentException('A selected document is missing or is not SOP/WI. No changes were saved.');
        }
    }

    private function updateOwnerDocuments(array $documents, $ownerId)
    {
        // Validate first, then issue one UPDATE; MyISAM cannot roll back a transaction.
        $this->selectedDocumentsQuery($documents)->update(['OWNER_ID' => $ownerId]);
    }

    private function selectedDocumentsQuery(array $documents)
    {
        return Masterlist::whereIn('CATID', ['SOP', 'WI'])
            ->where(function ($selection) use ($documents) {
                foreach ($documents as $document) {
                    $selection->orWhere(function ($identity) use ($document) {
                        $identity->where('DOCID', $document['DOCID'])
                            ->where('DOCREV', $document['DOCREV']);
                    });
                }
            });
    }

    private function validatedOwnerId($ownerId)
    {
        if (!is_string($ownerId) && !is_int($ownerId)) {
            throw new \InvalidArgumentException('Select a valid document owner.');
        }
        $ownerId = trim((string) $ownerId);
        if ($ownerId === '' || !ctype_digit($ownerId) || !User::where('id', (int) $ownerId)->exists()) {
            throw new \InvalidArgumentException('Select a valid document owner.');
        }
        return (int) $ownerId;
    }

    private function validatedNullableOwnerId($ownerId)
    {
        if ($ownerId === null || $ownerId === '') {
            return null;
        }
        return $this->validatedOwnerId($ownerId);
    }

    private function canManageOwner()
    {
        $userLevel = UserLevel::where('userid', Auth::user()->id)->first();
        return $userLevel && $userLevel->role === 'superuser';
    }

    private function annualReviewDueExpression()
    {
        return $this->nextReviewDateExpression().' <= '.($this->isSqlite() ? "DATE('now')" : 'CURDATE()');
    }

    private function nextReviewDateExpression()
    {
        return DocumentReviewCycle::nextReviewDateExpression(DB::connection('mysql3')->getDriverName());
    }

    private function isSqlite()
    {
        return DB::connection('mysql3')->getDriverName() === 'sqlite';
    }
}
