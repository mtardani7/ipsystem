<?php

namespace Tests\Feature;

use App\User;
use App\Mail\DocumentReviewReminder;
use App\DocumentReviewReminderService;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DocumentOwnerBulkUpdateTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        config([
            'database.connections.mysql3' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
                'foreign_key_constraints' => false,
            ],
        ]);
        DB::purge('mysql3');

        Schema::connection('mysql3')->create('users', function ($table) {
            $table->increments('id');
            $table->string('username');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('remember_token')->nullable();
        });
        Schema::connection('mysql3')->create('user_levels', function ($table) {
            $table->integer('userid')->primary();
            $table->string('role');
            $table->string('dept')->nullable();
            $table->string('plant')->nullable();
            $table->string('level')->nullable();
        });
        Schema::connection('mysql3')->create('division', function ($table) {
            $table->string('DIVID')->primary();
        });
        Schema::connection('mysql3')->create('tbl_request', function ($table) {
            $table->increments('id');
            $table->dateTime('date_request')->nullable();
            $table->string('dept')->nullable();
            $table->string('plant')->nullable();
            $table->string('type')->nullable();
            $table->string('reqby')->nullable();
            $table->string('form_saved')->nullable();
            $table->string('status')->nullable();
            $table->string('approval1')->nullable();
            $table->string('approval2')->nullable();
            $table->string('approval_final')->nullable();
            $table->string('approval_mr')->nullable();
            $table->dateTime('approval1_date')->nullable();
            $table->dateTime('approval2_Date')->nullable();
            $table->dateTime('approval_final_date')->nullable();
            $table->dateTime('approval_mr_date')->nullable();
            $table->string('verified')->nullable();
            $table->string('session_id')->nullable();
        });
        Schema::connection('mysql3')->create('masterlist', function ($table) {
            $table->string('DOCID');
            $table->string('DOCREV');
            $table->string('CATID');
            $table->integer('OWNER_ID')->nullable();
            $table->string('INPUTBY')->nullable();
            $table->string('REVISION_DATE')->nullable();
            $table->string('DOCSTATUS')->nullable();
            $table->string('REVIEWED')->nullable();
            $table->integer('REVIEWED_BY')->nullable();
            $table->string('REVIEWED_AT')->nullable();
            $table->string('REVIEW_NOTE')->nullable();
        });
        Schema::connection('mysql3')->create('document_review_reminder_tracking', function ($table) {
            $table->string('DOCID', 50);
            $table->string('DOCREV', 50);
            $table->string('REMINDER_CYCLE', 64)->nullable();
            $table->primary(['DOCID', 'DOCREV']);
        });

        DB::connection('mysql3')->table('users')->insert([
            ['id' => 1, 'username' => 'qms', 'name' => 'QMS User', 'email' => 'qms@example.test', 'password' => ''],
            ['id' => 2, 'username' => 'owner', 'name' => 'Document Owner', 'email' => 'owner@example.test', 'password' => ''],
            ['id' => 3, 'username' => 'viewer', 'name' => 'Viewer', 'email' => 'viewer@example.test', 'password' => ''],
            ['id' => 4, 'username' => 'admin', 'name' => 'Admin User', 'email' => 'admin@example.test', 'password' => ''],
            ['id' => 5, 'username' => 'ownerb', 'name' => 'Other Owner', 'email' => 'ownerb@example.test', 'password' => ''],
        ]);
        DB::connection('mysql3')->table('user_levels')->insert([
            ['userid' => 1, 'role' => 'superuser', 'dept' => 'QMS', 'plant' => 'P1', 'level' => 'staff'],
            ['userid' => 2, 'role' => 'user', 'dept' => 'ENG1', 'plant' => 'P1', 'level' => 'staff'],
            ['userid' => 3, 'role' => 'user', 'dept' => 'ENG1', 'plant' => 'P1', 'level' => 'staff'],
            ['userid' => 4, 'role' => 'admin', 'dept' => 'QMS', 'plant' => 'P1', 'level' => 'staff'],
            ['userid' => 5, 'role' => 'user', 'dept' => 'ENG1', 'plant' => 'P1', 'level' => 'staff'],
        ]);
    }

    public function test_three_selected_documents_are_updated_with_one_owner_update()
    {
        $documents = [
            ['DOCID' => 'WI-001', 'DOCREV' => '01', 'CATID' => 'WI'],
            ['DOCID' => 'WI-002', 'DOCREV' => '02', 'CATID' => 'WI'],
            ['DOCID' => 'SOP-001', 'DOCREV' => '01', 'CATID' => 'SOP'],
        ];
        $this->insertDocuments($documents);
        $this->loginAs(1);
        $this->enableQueryLog();

        $response = $this->postOwnerPayload($this->ownerPayload($documents));
        $response->assertSessionHas('success', '3 documents updated successfully.');

        $rows = DB::connection('mysql3')->table('masterlist')->get();
        foreach ($rows as $row) {
            $this->assertEquals(2, $row->OWNER_ID);
            $this->assertEquals('original-inputter', $row->INPUTBY);
            $this->assertEquals('2024-01-10', $row->REVISION_DATE);
            $this->assertEquals('Active', $row->DOCSTATUS);
            $this->assertEquals('PENDING', $row->REVIEWED);
            $this->assertEquals(3, $row->REVIEWED_BY);
            $this->assertEquals('2024-01-11 10:00:00', $row->REVIEWED_AT);
            $this->assertEquals('existing note', $row->REVIEW_NOTE);
        }
        $this->assertCount(1, $this->masterlistUpdateQueries());
    }

    public function test_admin_can_access_document_review_page_read_only()
    {
        $this->loginAs(4);

        $this->get('/document-owner')->assertStatus(200);
    }

    public function test_regular_user_can_access_document_review_page()
    {
        $this->loginAs(3);

        $this->get('/document-owner')->assertStatus(200);
    }

    public function test_superuser_can_access_document_review_page()
    {
        $this->loginAs(1);

        $this->get('/document-owner')->assertStatus(200);
    }

    public function test_approval_badge_includes_only_current_owners_documents_needing_review()
    {
        $documents = [
            ['DOCID' => 'WI-OWNER-REVIEW-DUE', 'DOCREV' => '01', 'CATID' => 'WI'],
            ['DOCID' => 'SOP-OTHER-OWNER-REVIEW-DUE', 'DOCREV' => '01', 'CATID' => 'SOP'],
            ['DOCID' => 'WI-OWNER-REVIEW-NOT-DUE', 'DOCREV' => '01', 'CATID' => 'WI'],
        ];
        $this->insertDocuments($documents);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-OWNER-REVIEW-DUE')->update(['OWNER_ID' => 2]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'SOP-OTHER-OWNER-REVIEW-DUE')->update(['OWNER_ID' => 5]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-OWNER-REVIEW-NOT-DUE')->update([
            'OWNER_ID' => 2,
            'REVISION_DATE' => \Carbon\Carbon::tomorrow()->format('Y-m-d'),
        ]);
        DB::connection('mysql3')->table('user_levels')->where('userid', 2)->update(['level' => 'approver']);
        $this->loginAs(2);

        $response = $this->get('/document-owner');

        $response->assertStatus(200);
        $this->assertContains('Approval <span class="badge">1</span>', $response->getContent());
    }

    public function test_staff_owner_sees_due_review_badge_on_document_review_navigation()
    {
        $document = ['DOCID' => 'WI-STAFF-REVIEW-DUE', 'DOCREV' => '01', 'CATID' => 'WI'];
        $this->insertDocuments([$document]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', $document['DOCID'])->update(['OWNER_ID' => 2]);
        $this->loginAs(2);

        $response = $this->get('/document-owner');

        $response->assertStatus(200);
        $this->assertContains('Document Review <span class="badge">1</span>', $response->getContent());
        $this->assertNotContains('Approval <span class="badge">', $response->getContent());
    }

    public function test_document_review_table_shows_revision_and_review_dates()
    {
        $this->insertDocuments([
            ['DOCID' => 'SOP/05-IT/01', 'DOCREV' => '03 (18-07-2023)', 'CATID' => 'SOP'],
        ]);
        $this->loginAs(1);

        $response = $this->get('/document-owner');

        $response->assertStatus(200);
        $this->assertContains('<th>Revision Date</th>', $response->getContent());
        $this->assertContains('<th>Last Review Date</th>', $response->getContent());
        $this->assertContains('<th>Next Review Date</th>', $response->getContent());
        $this->assertContains('<th>Review Notes</th>', $response->getContent());
        $this->assertContains('existing note', $response->getContent());
        $this->assertContains('<small>Rev 03 (18-07-2023)</small>', $response->getContent());
        $this->assertNotContains('Set Revision Date', $response->getContent());
    }

    public function test_owner_sees_review_action_but_other_user_does_not()
    {
        $document = ['DOCID' => 'WI-REVIEW-UI', 'DOCREV' => '01', 'CATID' => 'WI'];
        $this->insertDocuments([$document]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-REVIEW-UI')->update(['OWNER_ID' => 2]);

        $this->loginAs(2);
        $ownerPage = $this->get('/document-owner');
        $ownerPage->assertStatus(200);
        $this->assertContains('>Review</button>', $ownerPage->getContent());
        $this->assertContains('class="document-actions"', $ownerPage->getContent());
        $this->assertContains('class="btn btn-default btn-xs document-view-button"', $ownerPage->getContent());
        $this->assertContains('class="document-view-form"', $ownerPage->getContent());
        $this->assertContains('</i> View</button>', $ownerPage->getContent());
        $this->assertNotContains('class="document-selection"', $ownerPage->getContent());

        $this->loginAs(3);
        $otherUserPage = $this->get('/document-owner');
        $otherUserPage->assertStatus(200);
        $this->assertNotContains('>Review</button>', $otherUserPage->getContent());
        $this->assertContains('Document Owner', $otherUserPage->getContent());
    }

    public function test_my_documents_filter_only_shows_documents_owned_by_current_user()
    {
        $this->insertDocuments([
            ['DOCID' => 'WI-MY-DOC', 'DOCREV' => '01', 'CATID' => 'WI'],
            ['DOCID' => 'WI-OTHER-DOC', 'DOCREV' => '01', 'CATID' => 'WI'],
        ]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-MY-DOC')->update(['OWNER_ID' => 2]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-OTHER-DOC')->update(['OWNER_ID' => 1]);
        $this->loginAs(2);

        $response = $this->get('/document-owner?my_documents=1');

        $response->assertStatus(200);
        $this->assertContains('WI-MY-DOC', $response->getContent());
        $this->assertNotContains('WI-OTHER-DOC', $response->getContent());
    }

    public function test_regular_user_only_sees_own_documents_and_scoped_summaries()
    {
        $this->insertDocuments([
            ['DOCID' => 'WI-OWNER-A', 'DOCREV' => '01', 'CATID' => 'WI'],
            ['DOCID' => 'WI-OWNER-B', 'DOCREV' => '01', 'CATID' => 'WI'],
            ['DOCID' => 'WI-UNASSIGNED', 'DOCREV' => '01', 'CATID' => 'WI'],
        ]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-OWNER-A')->update(['OWNER_ID' => 2]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-OWNER-B')->update([
            'OWNER_ID' => 5,
            'REVIEWED' => 'OK',
        ]);
        $this->loginAs(2);

        $response = $this->get('/document-owner');

        $response->assertStatus(200);
        $this->assertContains('WI-OWNER-A', $response->getContent());
        $this->assertNotContains('WI-OWNER-B', $response->getContent());
        $this->assertNotContains('WI-UNASSIGNED', $response->getContent());
        $this->assertNotContains('owner_filter_owner', $response->getContent());
        $summary = $this->renderedSummary($response->getContent());
        $this->assertEquals([
            'Active SOP/WI' => '1',
            'Without Owner' => '0',
            'Ready for Review' => '1',
            'Review Completed' => '0',
        ], $summary);
    }

    public function test_query_filters_cannot_expose_other_owners_or_unassigned_documents()
    {
        $this->insertDocuments([
            ['DOCID' => 'WI-PRIVATE-B', 'DOCREV' => '01', 'CATID' => 'WI'],
            ['DOCID' => 'WI-PRIVATE-NULL', 'DOCREV' => '01', 'CATID' => 'WI'],
            ['DOCID' => 'WI-PRIVATE-A', 'DOCREV' => '01', 'CATID' => 'WI'],
        ]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-PRIVATE-B')->update(['OWNER_ID' => 5]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-PRIVATE-A')->update(['OWNER_ID' => 2]);
        $this->loginAs(2);

        $otherOwnerFilter = $this->get('/document-owner?owner=5&my_documents=0&search=WI-PRIVATE-B&category=WI&division=ENG1&status=ALL&document_status=ALL');
        $unassignedFilter = $this->get('/document-owner?owner=unassigned&my_documents=0&search=WI-PRIVATE-NULL&category=WI&document_status=ALL');

        $otherOwnerFilter->assertStatus(200);
        $unassignedFilter->assertStatus(200);
        $this->assertNotContains('WI-PRIVATE-B', $this->renderedTableBody($otherOwnerFilter->getContent()));
        $this->assertNotContains('WI-PRIVATE-NULL', $this->renderedTableBody($unassignedFilter->getContent()));
    }

    public function test_assigned_user_cannot_change_another_documents_owner()
    {
        $document = ['DOCID' => 'WI-OWNER-B-PRIVATE', 'DOCREV' => '01', 'CATID' => 'WI'];
        $this->insertDocuments([$document]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-OWNER-B-PRIVATE')->update(['OWNER_ID' => 5]);
        $this->loginAs(2);
        $this->enableQueryLog();

        $singleResponse = $this->postSingleOwner([
            'document_id' => 'WI-OWNER-B-PRIVATE',
            'document_revision' => '01',
            'owner_id' => '2',
        ]);
        $bulkResponse = $this->postOwnerPayload($this->ownerPayload([$document]));

        $singleResponse->assertStatus(403);
        $bulkResponse->assertStatus(403);
        $this->assertEquals(5, DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-OWNER-B-PRIVATE')->value('OWNER_ID'));
        $this->assertCount(0, $this->masterlistUpdateQueries());
    }

    public function test_user_without_assigned_documents_sees_owner_specific_empty_state()
    {
        $this->insertDocuments([
            ['DOCID' => 'WI-OWNER-B', 'DOCREV' => '01', 'CATID' => 'WI'],
            ['DOCID' => 'WI-UNASSIGNED', 'DOCREV' => '01', 'CATID' => 'WI'],
        ]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-OWNER-B')->update(['OWNER_ID' => 5]);
        $this->loginAs(3);

        $response = $this->get('/document-owner');

        $response->assertStatus(200);
        $this->assertContains('Tidak ada dokumen untuk direview.', $response->getContent());
        $this->assertContains('Belum ada SOP/WI yang ditugaskan kepada Anda sebagai Document Owner.', $response->getContent());
        $this->assertNotContains('WI-OWNER-B', $response->getContent());
        $this->assertNotContains('WI-UNASSIGNED', $response->getContent());
    }

    public function test_superuser_sees_documents_owned_by_anyone_and_unassigned()
    {
        $this->insertDocuments([
            ['DOCID' => 'WI-SUPER-A', 'DOCREV' => '01', 'CATID' => 'WI'],
            ['DOCID' => 'WI-SUPER-B', 'DOCREV' => '01', 'CATID' => 'WI'],
            ['DOCID' => 'WI-SUPER-NULL', 'DOCREV' => '01', 'CATID' => 'WI'],
        ]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-SUPER-A')->update(['OWNER_ID' => 2]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-SUPER-B')->update(['OWNER_ID' => 5]);
        $this->loginAs(1);

        $response = $this->get('/document-owner');

        $response->assertStatus(200);
        $this->assertContains('WI-SUPER-A', $response->getContent());
        $this->assertContains('WI-SUPER-B', $response->getContent());
        $this->assertContains('WI-SUPER-NULL', $response->getContent());
        $this->assertContains('Set Owner', $response->getContent());
        $this->assertEquals([
            'Active SOP/WI' => '3',
            'Without Owner' => '1',
            'Ready for Review' => '2',
            'Review Completed' => '0',
        ], $this->renderedSummary($response->getContent()));
    }

    public function test_cycle_uses_review_date_then_a_newer_revision_date()
    {
        $this->assertEquals(
            '2027-10-05',
            \App\DocumentReviewCycle::nextReviewDate('2020-08-15', '2026-10-05 12:00:00')->format('Y-m-d')
        );
        $this->assertEquals(
            '2027-11-20',
            \App\DocumentReviewCycle::nextReviewDate('2026-11-20', '2026-10-05 12:00:00')->format('Y-m-d')
        );
        $this->assertEquals(
            '2021-08-15',
            \App\DocumentReviewCycle::nextReviewDate('2020-08-15', null)->format('Y-m-d')
        );
        $this->assertEquals(
            '2025-02-28',
            \App\DocumentReviewCycle::nextReviewDate('2024-02-29', null)->format('Y-m-d')
        );
        $this->assertEquals(
            '2026-10-02',
            \App\DocumentReviewCycle::nextReviewDate(null, '2025-10-02 18:30:00')->format('Y-m-d')
        );
        $this->assertEquals(
            '2024-07-18',
            \App\DocumentReviewCycle::nextReviewDate(null, null, '03 (18-07-2023)')->format('Y-m-d')
        );
        $this->assertNull(\App\DocumentReviewCycle::nextReviewDate(null, null, '03 (31-02-2023)'));
    }

    public function test_docrev_formats_are_validated_and_sql_matches_php()
    {
        $cycle = '\\App\\DocumentReviewCycle';
        $this->assertEquals('2007-04-13', $cycle::revisionDate(null, '00 (13.04.2007)')->format('Y-m-d'));
        $this->assertEquals('2015-10-30', $cycle::revisionDate(null, '00 (30-10-2015)')->format('Y-m-d'));
        $this->assertNull($cycle::revisionDate(null, '00 (31.02.2023)'));
        $this->assertNull($cycle::revisionDate('2020-01-01', '00 (31.02.2023)'));
        $this->assertEquals('2015-10-30', $cycle::revisionDate('2000-01-01', '00 (30-10-2015)')->format('Y-m-d'));
        foreach (['00 (13.04.2007)', '00 (30-10-2015)', '00 (31.02.2023)'] as $docrev) {
            DB::connection('mysql3')->table('masterlist')->insert([
                'DOCID' => 'SQL-DATE-'.md5($docrev), 'DOCREV' => $docrev, 'CATID' => 'WI',
                'REVISION_DATE' => $docrev === '00 (31.02.2023)' ? '2020-01-01' : null,
            ]);
        }
        $rows = DB::connection('mysql3')->table('masterlist')->where('DOCID', 'like', 'SQL-DATE-%')
            ->select('DOCREV')->selectRaw($cycle::revisionDateExpression('sqlite').' AS PARSED')->get();
        $this->assertEquals(['2007-04-13', '2015-10-30', null], array_map(function ($row) {
            return $row->PARSED;
        }, $rows->all()));
    }

    public function test_existing_docrev_date_enables_review_without_populating_revision_date()
    {
        $document = ['DOCID' => 'SOP/05-IT/01', 'DOCREV' => '03 (18-07-2023)', 'CATID' => 'SOP'];
        $this->insertDocuments([$document]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', $document['DOCID'])->update([
            'OWNER_ID' => 2,
            'REVISION_DATE' => null,
            'REVIEWED_AT' => null,
        ]);

        $this->loginAs(2);
        $page = $this->get('/document-owner');
        $page->assertStatus(200);
        $this->assertContains('>NEEDS REVIEW</span>', $page->getContent());
        $this->assertContains('class="btn btn-primary btn-xs document-review-trigger"', $page->getContent());
        $this->assertContains('data-revision-date="18-07-2023"', $page->getContent());
        $this->assertEquals('1', $this->renderedSummary($page->getContent())['Ready for Review']);

        $response = $this->postReview([
            'document_id' => $document['DOCID'],
            'document_revision' => $document['DOCREV'],
            'review_status' => 'OK',
            'review_note' => 'Still valid.',
        ]);
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $row = DB::connection('mysql3')->table('masterlist')->where('DOCID', $document['DOCID'])->first();
        $this->assertNull($row->REVISION_DATE);
        $this->assertEquals('OK', $row->REVIEWED);
        $this->assertNotNull($row->REVIEWED_AT);
    }

    public function test_owner_cannot_review_before_the_cycle_due_date()
    {
        $revisionDate = \Carbon\Carbon::tomorrow()->subYear()->format('Y-m-d');
        $document = ['DOCID' => 'WI-NOT-DUE', 'DOCREV' => '01', 'CATID' => 'WI'];
        $this->insertDocuments([$document]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-NOT-DUE')->update([
            'OWNER_ID' => 2,
            'REVISION_DATE' => $revisionDate,
            'REVIEWED_AT' => null,
        ]);
        $this->loginAs(2);

        $page = $this->get('/document-owner');
        $this->assertContains('>NOT DUE</span>', $page->getContent());
        $this->assertContains('title="Annual review belum jatuh tempo."', $page->getContent());

        $response = $this->postReview([
            'document_id' => 'WI-NOT-DUE',
            'document_revision' => '01',
            'review_status' => 'OK',
            'review_note' => 'Premature review.',
        ]);
        $this->assertEquals(422, $response->getStatusCode(), $response->getContent());
        $this->assertEquals('PENDING', DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-NOT-DUE')->value('REVIEWED'));
    }

    public function test_reminder_is_sent_once_per_review_cycle_and_again_for_new_revision()
    {
        $document = ['DOCID' => 'WI-REMINDER', 'DOCREV' => '01', 'CATID' => 'WI'];
        $this->insertDocuments([$document]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-REMINDER')->update([
            'OWNER_ID' => 2,
            'REVISION_DATE' => '2020-08-15',
            'REVIEWED_AT' => null,
        ]);
        Mail::fake();

        Artisan::call('document-review:send-reminders');
        $this->assertEquals('revision:2020-08-15', DB::connection('mysql3')->table('document_review_reminder_tracking')->where('DOCID', 'WI-REMINDER')->value('REMINDER_CYCLE'));
        $this->assertCount(1, Mail::sent(DocumentReviewReminder::class));

        Artisan::call('document-review:send-reminders');
        $this->assertCount(1, Mail::sent(DocumentReviewReminder::class));

        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-REMINDER')->update(['REVISION_DATE' => '2025-01-01']);
        Artisan::call('document-review:send-reminders');
        $this->assertEquals('revision:2025-01-01', DB::connection('mysql3')->table('document_review_reminder_tracking')->where('DOCID', 'WI-REMINDER')->value('REMINDER_CYCLE'));
        $this->assertCount(2, Mail::sent(DocumentReviewReminder::class));
        $this->assertEquals('owner@example.test', Mail::sent(DocumentReviewReminder::class)->first()->to[0]['address']);
    }

    public function test_existing_docrev_date_is_eligible_for_review_reminder()
    {
        $document = ['DOCID' => 'WI-LEGACY-REMINDER', 'DOCREV' => '03 (18-07-2023)', 'CATID' => 'WI'];
        $this->insertDocuments([$document]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', $document['DOCID'])->update([
            'OWNER_ID' => 2,
            'REVISION_DATE' => null,
            'REVIEWED_AT' => null,
        ]);
        Mail::fake();

        Artisan::call('document-review:send-reminders');

        Mail::assertSent(DocumentReviewReminder::class);
        $this->assertEquals(
            'revision:2023-07-18',
            DB::connection('mysql3')->table('document_review_reminder_tracking')->where('DOCID', $document['DOCID'])->value('REMINDER_CYCLE')
        );
        $this->assertNull(DB::connection('mysql3')->table('masterlist')->where('DOCID', $document['DOCID'])->value('REVISION_DATE'));
    }

    public function test_reminders_are_not_sent_for_not_due_unassigned_non_sop_or_inactive_documents()
    {
        $documents = [
            ['DOCID' => 'WI-REMINDER-FUTURE', 'DOCREV' => '01', 'CATID' => 'WI'],
            ['DOCID' => 'WI-REMINDER-UNASSIGNED', 'DOCREV' => '01', 'CATID' => 'WI'],
            ['DOCID' => 'FORM-REMINDER', 'DOCREV' => '01', 'CATID' => 'FORM'],
            ['DOCID' => 'WI-REMINDER-INACTIVE', 'DOCREV' => '01', 'CATID' => 'WI'],
        ];
        $this->insertDocuments($documents);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-REMINDER-FUTURE')->update([
            'OWNER_ID' => 2,
            'REVISION_DATE' => \Carbon\Carbon::tomorrow()->format('Y-m-d'),
            'REVIEWED_AT' => null,
        ]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'FORM-REMINDER')->update(['OWNER_ID' => 2]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-REMINDER-INACTIVE')->update([
            'OWNER_ID' => 2,
            'DOCSTATUS' => 'Obsolete',
        ]);
        Mail::fake();

        Artisan::call('document-review:send-reminders');

        Mail::assertNothingSent();
        $this->assertNull(DB::connection('mysql3')->table('document_review_reminder_tracking')->where('DOCID', 'WI-REMINDER-FUTURE')->value('REMINDER_CYCLE'));
        $this->assertNull(DB::connection('mysql3')->table('document_review_reminder_tracking')->where('DOCID', 'WI-REMINDER-UNASSIGNED')->value('REMINDER_CYCLE'));
    }

    public function test_superuser_can_preview_reminder_groups_and_owner_assignment_warning()
    {
        $documents = [
            ['DOCID' => 'WI-PREVIEW-A1', 'DOCREV' => '01', 'CATID' => 'WI'],
            ['DOCID' => 'WI-PREVIEW-A2', 'DOCREV' => '01', 'CATID' => 'WI'],
            ['DOCID' => 'SOP-PREVIEW-B', 'DOCREV' => '01', 'CATID' => 'SOP'],
            ['DOCID' => 'WI-PREVIEW-NULL', 'DOCREV' => '01', 'CATID' => 'WI'],
        ];
        $this->insertDocuments($documents);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-PREVIEW-A1')->update(['OWNER_ID' => 2]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-PREVIEW-A2')->update(['OWNER_ID' => 2]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'SOP-PREVIEW-B')->update(['OWNER_ID' => 5]);
        $this->loginAs(1);

        $page = $this->get('/document-owner');
        $page->assertStatus(200);
        $this->assertNotContains('Owner Assignment Incomplete', $page->getContent());
        $this->assertNotContains('Manage Owner', $page->getContent());
        $this->assertContains('data-preview-url="'.route('document_owner.reminders.preview').'"', $page->getContent());
        $this->assertNotContains('>Refresh</a>', $page->getContent());
        $this->assertContains('Kirim Reminder Review', $page->getContent());

        $preview = $this->get('/document-owner/reminders/preview');
        $this->assertEquals(200, $preview->getStatusCode(), $preview->getContent());
        $this->assertEquals([
            'documents' => 3,
            'owners' => 2,
            'without_owner' => 1,
            'tracking_available' => true,
        ], json_decode($preview->getContent(), true));
    }

    public function test_reminder_preview_is_available_before_tracking_migration_and_send_is_blocked()
    {
        Schema::connection('mysql3')->drop('document_review_reminder_tracking');
        DB::connection('mysql3')->table('masterlist')->insert([
            'DOCID' => 'WI-PREVIEW-WITHOUT-TRACKING',
            'DOCREV' => '01',
            'CATID' => 'WI',
            'OWNER_ID' => 2,
            'INPUTBY' => 'original-inputter',
            'REVISION_DATE' => '2024-01-10',
            'DOCSTATUS' => 'Active',
            'REVIEWED' => null,
            'REVIEWED_BY' => null,
            'REVIEWED_AT' => null,
            'REVIEW_NOTE' => null,
        ]);
        $this->loginAs(1);

        $page = $this->get('/document-owner');
        $page->assertStatus(200);
        $this->assertContains('Kirim Reminder Review', $page->getContent());

        $preview = $this->get('/document-owner/reminders/preview');
        $this->assertEquals(200, $preview->getStatusCode(), $preview->getContent());
        $this->assertFalse(json_decode($preview->getContent(), true)['tracking_available']);

        $this->postWithCsrf('/document-owner/reminders/send', [])->assertStatus(503);
    }

    public function test_manual_reminders_send_one_email_per_owner_and_do_not_change_document_business_data()
    {
        $documents = [
            ['DOCID' => 'WI-GROUP-A1', 'DOCREV' => '01', 'CATID' => 'WI'],
            ['DOCID' => 'WI-GROUP-A2', 'DOCREV' => '01', 'CATID' => 'WI'],
            ['DOCID' => 'SOP-GROUP-B1', 'DOCREV' => '01', 'CATID' => 'SOP'],
            ['DOCID' => 'WI-GROUP-UNASSIGNED', 'DOCREV' => '01', 'CATID' => 'WI'],
        ];
        $this->insertDocuments($documents);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-GROUP-A1')->update(['OWNER_ID' => 2]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-GROUP-A2')->update(['OWNER_ID' => 2]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'SOP-GROUP-B1')->update(['OWNER_ID' => 5]);
        $this->loginAs(1);
        Mail::fake();
        $before = DB::connection('mysql3')->table('masterlist')->get()->keyBy('DOCID');

        $response = $this->postWithCsrf('/document-owner/reminders/send', []);

        $response->assertRedirect(route('document_owner'));
        $this->assertEquals([
            'owners' => 2,
            'documents' => 3,
            'emails_sent' => 2,
            'failed' => 0,
            'failures' => [],
        ], session('reminder_result'));
        $this->assertCount(2, Mail::sent(DocumentReviewReminder::class));
        $groupedMail = Mail::sent(DocumentReviewReminder::class)->first();
        $this->assertCount(2, $groupedMail->documents);
        $this->assertContains('WI-GROUP-A1', array_map(function ($document) {
            return $document->DOCID;
        }, $groupedMail->documents));
        $this->assertEquals(2, DB::connection('mysql3')->table('document_review_reminder_tracking')->whereIn('DOCID', ['WI-GROUP-A1', 'WI-GROUP-A2'])->whereNotNull('REMINDER_CYCLE')->count());
        $this->assertNull(DB::connection('mysql3')->table('document_review_reminder_tracking')->where('DOCID', 'WI-GROUP-UNASSIGNED')->value('REMINDER_CYCLE'));

        foreach (DB::connection('mysql3')->table('masterlist')->get() as $after) {
            $this->assertEquals($before[$after->DOCID]->OWNER_ID, $after->OWNER_ID);
            $this->assertEquals($before[$after->DOCID]->INPUTBY, $after->INPUTBY);
            $this->assertEquals($before[$after->DOCID]->DOCREV, $after->DOCREV);
            $this->assertEquals($before[$after->DOCID]->REVISION_DATE, $after->REVISION_DATE);
            $this->assertEquals($before[$after->DOCID]->DOCSTATUS, $after->DOCSTATUS);
            $this->assertEquals($before[$after->DOCID]->REVIEWED, $after->REVIEWED);
            $this->assertEquals($before[$after->DOCID]->REVIEWED_BY, $after->REVIEWED_BY);
            $this->assertEquals($before[$after->DOCID]->REVIEWED_AT, $after->REVIEWED_AT);
            $this->assertEquals($before[$after->DOCID]->REVIEW_NOTE, $after->REVIEW_NOTE);
        }
    }

    public function test_single_document_email_has_personalized_greeting_subject_and_html_and_text_content()
    {
        $description = str_repeat('Description for a long controlled document. ', 8);
        $document = (object) [
            'DOCID' => 'SOP/05-IT/01',
            'DOCDESC' => $description,
            'REVISION_LABEL' => 'Rev 03',
            'REVISION_DATE_LABEL' => '18-07-2023',
            'NEXT_REVIEW_DATE_LABEL' => '18-07-2026',
        ];
        $mail = new DocumentReviewReminder([
            'id' => 164,
            'name' => 'M Toyyibal Ardani',
            'email' => 'toyyibal.ardani@rapidplast.co.id',
        ], [$document]);
        $mail->build();

        $html = view($mail->view, $mail->buildViewData())->render();
        $plainText = view($mail->textView, $mail->buildViewData())->render();

        $this->assertEquals('[IPSystem] Document Review Required - SOP/05-IT/01', $mail->subject);
        $this->assertContains('Dear Bapak/Ibu M Toyyibal Ardani,', $html);
        $this->assertContains('Revision: Rev 03', $html);
        $this->assertContains('Revision Date: 18-07-2023', $html);
        $this->assertContains('Review Due: 18-07-2026', $html);
        $this->assertContains('Review Documents', $html);
        $this->assertContains(url('/document-owner'), $html);
        $this->assertContains('SOP/05-IT/01', $plainText);
        $this->assertContains('Dear Bapak/Ibu M Toyyibal Ardani,', $plainText);
        $this->assertContains($description, $plainText);
        $this->assertNotContains('mengisi alamat email', $html.$plainText);
        $this->assertNotContains('kolom Action di Masterlist', $html.$plainText);
    }

    public function test_multiple_document_email_has_single_owner_greeting_and_multiple_subject()
    {
        $documents = [
            (object) [
                'DOCID' => 'SOP/05-IT/01',
                'DOCDESC' => 'Back Up System',
                'REVISION_LABEL' => 'Rev 03',
                'REVISION_DATE_LABEL' => '18-07-2023',
                'NEXT_REVIEW_DATE_LABEL' => '18-07-2026',
            ],
            (object) [
                'DOCID' => 'WI/05-IT/02',
                'DOCDESC' => 'Network Maintenance',
                'REVISION_LABEL' => 'Rev 02',
                'REVISION_DATE_LABEL' => '20-07-2023',
                'NEXT_REVIEW_DATE_LABEL' => '20-07-2026',
            ],
        ];
        $mail = new DocumentReviewReminder(['id' => 2, 'name' => '', 'email' => 'owner@example.test'], $documents);
        $mail->build();
        $html = view($mail->view, $mail->buildViewData())->render();
        $plainText = view($mail->textView, $mail->buildViewData())->render();

        $this->assertEquals('[IPSystem] Annual Document Review Required - 2 Documents', $mail->subject);
        $this->assertContains('Dear Bapak/Ibu Pemilik Proses,', $html);
        $this->assertContains('Dear Bapak/Ibu Pemilik Proses,', $plainText);
        $this->assertContains('SOP/05-IT/01', $html);
        $this->assertContains('WI/05-IT/02', $html);
        $this->assertContains('SOP/05-IT/01', $plainText);
        $this->assertContains('WI/05-IT/02', $plainText);
        $this->assertEquals(2, substr_count($html, 'Review Due:'));
    }

    public function test_invalid_owner_id_and_missing_owner_email_are_not_sent()
    {
        $documents = [
            ['DOCID' => 'WI-OWNER-EMAIL-EMPTY', 'DOCREV' => '01', 'CATID' => 'WI'],
            ['DOCID' => 'WI-OWNER-ID-INVALID', 'DOCREV' => '01', 'CATID' => 'WI'],
        ];
        $this->insertDocuments($documents);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-OWNER-EMAIL-EMPTY')->update(['OWNER_ID' => 5]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-OWNER-ID-INVALID')->update(['OWNER_ID' => 999]);
        DB::connection('mysql3')->table('users')->where('id', 5)->update(['email' => null]);
        Mail::fake();

        $result = app(DocumentReviewReminderService::class)->send();

        Mail::assertNothingSent();
        $this->assertEquals(1, $result['failed']);
        $this->assertEquals(1, $result['owners']);
        $this->assertContains('No valid email address', $result['failures'][0]['reason']);
        $this->assertNull(DB::connection('mysql3')->table('document_review_reminder_tracking')->where('DOCID', 'WI-OWNER-EMAIL-EMPTY')->value('REMINDER_CYCLE'));
        $this->assertNull(DB::connection('mysql3')->table('document_review_reminder_tracking')->where('DOCID', 'WI-OWNER-ID-INVALID')->value('REMINDER_CYCLE'));
    }

    public function test_manual_reminders_do_not_repeat_same_cycle_and_include_new_revision()
    {
        $document = ['DOCID' => 'WI-GROUP-CYCLE', 'DOCREV' => '01 (01-01-2020)', 'CATID' => 'WI'];
        $this->insertDocuments([$document]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', $document['DOCID'])->update([
            'OWNER_ID' => 2,
            'REVISION_DATE' => null,
            'REVIEWED_AT' => null,
        ]);
        $this->loginAs(1);
        Mail::fake();

        $this->postWithCsrf('/document-owner/reminders/send', []);
        $this->postWithCsrf('/document-owner/reminders/send', []);
        $this->assertCount(1, Mail::sent(DocumentReviewReminder::class));

        DB::connection('mysql3')->table('masterlist')->where('DOCID', $document['DOCID'])->update(['DOCREV' => '02 (02-01-2021)']);
        $this->postWithCsrf('/document-owner/reminders/send', []);
        $this->assertCount(2, Mail::sent(DocumentReviewReminder::class));
    }

    public function test_non_superuser_cannot_preview_or_send_reminders()
    {
        $this->loginAs(2);

        $this->get('/document-owner/reminders/preview')->assertStatus(403);
        $this->postWithCsrf('/document-owner/reminders/send', [])->assertStatus(403);
    }

    public function test_failed_owner_email_does_not_stop_sending_to_the_next_owner()
    {
        $documents = [
            ['DOCID' => 'WI-FAIL-EMAIL-A', 'DOCREV' => '01', 'CATID' => 'WI'],
            ['DOCID' => 'WI-FAIL-EMAIL-B', 'DOCREV' => '01', 'CATID' => 'WI'],
        ];
        $this->insertDocuments($documents);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-FAIL-EMAIL-A')->update(['OWNER_ID' => 2]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-FAIL-EMAIL-B')->update(['OWNER_ID' => 5]);
        $this->loginAs(1);

        $failedMail = \Mockery::mock(\Illuminate\Mail\PendingMail::class);
        $failedMail->shouldReceive('send')->once()->andThrow(new \RuntimeException('SMTP credentials must not appear in the result.'));
        $successfulMail = \Mockery::mock(\Illuminate\Mail\PendingMail::class);
        $successfulMail->shouldReceive('send')->once();
        Mail::shouldReceive('to')->once()->with('owner@example.test')->andReturn($failedMail);
        Mail::shouldReceive('to')->once()->with('ownerb@example.test')->andReturn($successfulMail);

        $this->postWithCsrf('/document-owner/reminders/send', []);

        $result = session('reminder_result');
        $this->assertEquals(1, $result['emails_sent']);
        $this->assertEquals(1, $result['failed']);
        $this->assertNotContains('SMTP credentials', json_encode($result));
        $this->assertNull(DB::connection('mysql3')->table('document_review_reminder_tracking')->where('DOCID', 'WI-FAIL-EMAIL-A')->value('REMINDER_CYCLE'));
        $this->assertNotNull(DB::connection('mysql3')->table('document_review_reminder_tracking')->where('DOCID', 'WI-FAIL-EMAIL-B')->value('REMINDER_CYCLE'));
    }

    public function test_superuser_sees_owner_management_but_review_remains_owner_only()
    {
        $document = ['DOCID' => 'WI-OWNER-ONLY', 'DOCREV' => '01', 'CATID' => 'WI'];
        $this->insertDocuments([$document]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-OWNER-ONLY')->update(['OWNER_ID' => 2]);
        $this->loginAs(1);

        $response = $this->get('/document-owner');

        $response->assertStatus(200);
        $this->assertContains('document-selection', $response->getContent());
        $this->assertContains('Set Owner', $response->getContent());
        $this->assertNotContains('>Review</button>', $response->getContent());
    }

    public function test_assigned_owner_can_submit_ok_review_without_creating_request()
    {
        $document = ['DOCID' => 'WI-REV-OK', 'DOCREV' => '01', 'CATID' => 'WI'];
        $this->insertDocuments([$document]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-REV-OK')->update(['OWNER_ID' => 2]);
        $this->loginAs(2);

        $response = $this->postReview([
            'document_id' => 'WI-REV-OK',
            'document_revision' => '01',
            'review_status' => 'OK',
            'review_note' => 'Reviewed and acceptable.',
        ]);

        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertEquals([
            'message' => 'Document reviewed successfully.',
        ], json_decode($response->getContent(), true));
        $row = DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-REV-OK')->first();
        $this->assertEquals('OK', $row->REVIEWED);
        $this->assertEquals(2, $row->REVIEWED_BY);
        $this->assertNotNull($row->REVIEWED_AT);
        $this->assertEquals('Reviewed and acceptable.', $row->REVIEW_NOTE);
        $this->assertEquals('Active', $row->DOCSTATUS);
        $this->assertEquals(0, DB::connection('mysql3')->table('tbl_request')->count());
        $page = $this->get('/document-owner');
        $this->assertContains('>OK</span>', $page->getContent());
        $this->assertContains('title="Annual review belum jatuh tempo."', $page->getContent());
        $this->assertEquals('0', $this->renderedSummary($page->getContent())['Ready for Review']);
    }

    public function test_assigned_owner_nok_review_launches_existing_request_with_owner_identity()
    {
        $document = ['DOCID' => 'WI-REV-NOK', 'DOCREV' => '02', 'CATID' => 'WI'];
        $this->insertDocuments([$document]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-REV-NOK')->update(['OWNER_ID' => 2]);
        $this->loginAs(2);

        $reviewResponse = $this->postReview([
            'document_id' => 'WI-REV-NOK',
            'document_revision' => '02',
            'review_status' => 'NOK',
            'review_note' => 'Document needs correction.',
        ]);

        $this->assertEquals(200, $reviewResponse->getStatusCode(), $reviewResponse->getContent());
        $this->assertEquals(route('create_req'), json_decode($reviewResponse->getContent(), true)['request_url']);
        $this->assertEquals('NOK', DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-REV-NOK')->value('REVIEWED'));

        $requestResponse = $this->postWithCsrf('/create_req_form', [
            'req_by' => 'forged-requester',
            'req_dept' => 'FORGED-DEPT',
            'req_plant' => 'FORGED-PLANT',
            'req_type' => 'change-folder',
        ]);

        $this->assertEquals(200, $requestResponse->getStatusCode(), $requestResponse->getContent());
        $request = DB::connection('mysql3')->table('tbl_request')->first();
        $this->assertEquals('owner', $request->reqby);
        $this->assertEquals('ENG1', $request->dept);
        $this->assertEquals('P1', $request->plant);
        $this->assertNull(session('document_review_request_context'));
    }

    public function test_non_owner_cannot_submit_review_even_if_superuser()
    {
        $document = ['DOCID' => 'WI-REV-OWNER', 'DOCREV' => '01', 'CATID' => 'WI'];
        $this->insertDocuments([$document]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-REV-OWNER')->update(['OWNER_ID' => 2]);
        $this->loginAs(1);
        $this->enableQueryLog();

        $response = $this->postReview([
            'document_id' => 'WI-REV-OWNER',
            'document_revision' => '01',
            'review_status' => 'OK',
            'review_note' => 'Not authorized.',
        ]);

        $response->assertStatus(403);
        $this->assertEquals('PENDING', DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-REV-OWNER')->value('REVIEWED'));
        $this->assertCount(0, $this->masterlistUpdateQueries());
    }

    public function test_legacy_masterlist_review_endpoint_also_denies_non_owner_superuser()
    {
        $document = ['DOCID' => 'WI-LEGACY-REVIEW', 'DOCREV' => '01', 'CATID' => 'WI'];
        $this->insertDocuments([$document]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-LEGACY-REVIEW')->update(['OWNER_ID' => 2]);
        $this->loginAs(1);
        $this->enableQueryLog();

        $response = $this->postWithCsrf('/update_list', [
            'review_action' => 'review',
            'review_docid' => 'WI-LEGACY-REVIEW',
            'review_docrev' => '01',
            'review_status' => 'OK',
            'review_note' => 'Not owner.',
        ]);

        $response->assertStatus(403);
        $this->assertEquals('PENDING', DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-LEGACY-REVIEW')->value('REVIEWED'));
        $this->assertCount(0, $this->masterlistUpdateQueries());
    }

    public function test_review_rejects_non_sop_wi_or_inactive_document()
    {
        $documents = [
            ['DOCID' => 'FORM-REV', 'DOCREV' => '01', 'CATID' => 'FORM'],
            ['DOCID' => 'WI-OBSOLETE', 'DOCREV' => '01', 'CATID' => 'WI'],
        ];
        $this->insertDocuments($documents);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'FORM-REV')->update(['OWNER_ID' => 2]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-OBSOLETE')->update([
            'OWNER_ID' => 2,
            'DOCSTATUS' => 'Obsolete',
        ]);
        $this->loginAs(2);

        $badCategory = $this->postReview([
            'document_id' => 'FORM-REV',
            'document_revision' => '01',
            'review_status' => 'OK',
            'review_note' => 'Reviewed.',
        ]);
        $inactive = $this->postReview([
            'document_id' => 'WI-OBSOLETE',
            'document_revision' => '01',
            'review_status' => 'OK',
            'review_note' => 'Reviewed.',
        ]);

        $this->assertEquals(403, $badCategory->getStatusCode(), 'Bad category: '.$badCategory->getContent());
        $this->assertEquals(403, $inactive->getStatusCode(), 'Inactive: '.$inactive->getContent());
        $this->assertEquals('PENDING', DB::connection('mysql3')->table('masterlist')->where('DOCID', 'FORM-REV')->value('REVIEWED'));
        $this->assertEquals('PENDING', DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-OBSOLETE')->value('REVIEWED'));
    }

    public function test_invalid_selected_document_prevents_any_owner_update()
    {
        $valid = ['DOCID' => 'WI-001', 'DOCREV' => '01', 'CATID' => 'WI'];
        $this->insertDocuments([$valid]);
        $this->loginAs(1);
        $this->enableQueryLog();

        $response = $this->postOwnerPayload($this->ownerPayload([
            $valid,
            ['DOCID' => 'WI-MISSING', 'DOCREV' => '01'],
        ]));

        $response->assertSessionHas('data', 'Owner update failed. No documents were changed.');
        $this->assertNull(DB::connection('mysql3')->table('masterlist')->value('OWNER_ID'));
        $this->assertCount(0, $this->masterlistUpdateQueries());
    }

    public function test_non_qms_user_is_forbidden_from_bulk_owner_update()
    {
        $document = ['DOCID' => 'WI-001', 'DOCREV' => '01', 'CATID' => 'WI'];
        $this->insertDocuments([$document]);
        $this->loginAs(3);
        $this->enableQueryLog();

        $response = $this->postOwnerPayload($this->ownerPayload([$document]));

        $response->assertStatus(403);
        $this->assertNull(DB::connection('mysql3')->table('masterlist')->value('OWNER_ID'));
        $this->assertCount(0, $this->masterlistUpdateQueries());
    }

    public function test_admin_is_forbidden_from_bulk_owner_update()
    {
        $document = ['DOCID' => 'WI-001', 'DOCREV' => '01', 'CATID' => 'WI'];
        $this->insertDocuments([$document]);
        $this->loginAs(4);
        $this->enableQueryLog();

        $response = $this->postOwnerPayload($this->ownerPayload([$document]));

        $response->assertStatus(403);
        $this->assertNull(DB::connection('mysql3')->table('masterlist')->value('OWNER_ID'));
        $this->assertCount(0, $this->masterlistUpdateQueries());
    }

    public function test_invalid_owner_id_prevents_any_owner_update()
    {
        $document = ['DOCID' => 'WI-001', 'DOCREV' => '01', 'CATID' => 'WI'];
        $this->insertDocuments([$document]);
        $this->loginAs(1);
        $this->enableQueryLog();
        $payload = $this->ownerPayload([$document]);
        $payload['owner_id'] = '9999';

        $response = $this->postOwnerPayload($payload);

        $response->assertSessionHas('data', 'Owner update failed. No documents were changed.');
        $this->assertNull(DB::connection('mysql3')->table('masterlist')->value('OWNER_ID'));
        $this->assertCount(0, $this->masterlistUpdateQueries());
    }

    public function test_bulk_owner_update_rejects_documents_outside_sop_and_wi()
    {
        $valid = ['DOCID' => 'WI-001', 'DOCREV' => '01', 'CATID' => 'WI'];
        $otherCategory = ['DOCID' => 'FORM-001', 'DOCREV' => '01', 'CATID' => 'FORM'];
        $this->insertDocuments([$valid, $otherCategory]);
        $this->loginAs(1);
        $this->enableQueryLog();

        $response = $this->postOwnerPayload($this->ownerPayload([
            $valid,
            $otherCategory,
        ]));

        $response->assertSessionHas('data', 'Owner update failed. No documents were changed.');
        $this->assertNull(DB::connection('mysql3')->table('masterlist')->where('CATID', 'WI')->value('OWNER_ID'));
        $this->assertNull(DB::connection('mysql3')->table('masterlist')->where('CATID', 'FORM')->value('OWNER_ID'));
        $this->assertCount(0, $this->masterlistUpdateQueries());
    }

    public function test_single_owner_assignment_updates_only_the_selected_document()
    {
        $document = ['DOCID' => 'WI-001', 'DOCREV' => '01', 'CATID' => 'WI'];
        $untouched = ['DOCID' => 'WI-002', 'DOCREV' => '01', 'CATID' => 'WI'];
        $this->insertDocuments([$document, $untouched]);
        $this->loginAs(1);
        $this->enableQueryLog();

        $response = $this->postSingleOwner([
            'document_id' => 'WI-001',
            'document_revision' => '01',
            'owner_id' => '2',
        ]);

        $response->assertSessionHas('success', 'Document owner updated successfully.');
        $this->assertEquals(2, DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-001')->value('OWNER_ID'));
        $this->assertNull(DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-002')->value('OWNER_ID'));
        $row = DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-001')->first();
        $this->assertEquals('original-inputter', $row->INPUTBY);
        $this->assertEquals('01', $row->DOCREV);
        $this->assertEquals('2024-01-10', $row->REVISION_DATE);
        $this->assertEquals('Active', $row->DOCSTATUS);
        $this->assertEquals('PENDING', $row->REVIEWED);
        $this->assertEquals(3, $row->REVIEWED_BY);
        $this->assertEquals('2024-01-11 10:00:00', $row->REVIEWED_AT);
        $this->assertEquals('existing note', $row->REVIEW_NOTE);
        $this->assertCount(1, $this->masterlistUpdateQueries());
    }

    public function test_single_owner_ajax_request_returns_success_json()
    {
        $document = ['DOCID' => 'WI-001', 'DOCREV' => '01', 'CATID' => 'WI'];
        $this->insertDocuments([$document]);
        $this->loginAs(1);

        $response = $this->postSingleOwner([
            'document_id' => 'WI-001',
            'document_revision' => '01',
            'owner_id' => '2',
        ], ['HTTP_ACCEPT' => 'application/json']);

        $response->assertStatus(200);
        $this->assertEquals([
            'message' => 'Owner updated successfully.',
            'owner_id' => 2,
            'owner_name' => 'Document Owner',
        ], json_decode($response->getContent(), true));
    }

    public function test_single_owner_can_be_cleared_to_not_assigned()
    {
        $document = ['DOCID' => 'WI-001', 'DOCREV' => '01', 'CATID' => 'WI'];
        $this->insertDocuments([$document]);
        DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-001')->update(['OWNER_ID' => 2]);
        $this->loginAs(1);

        $response = $this->postSingleOwner([
            'document_id' => 'WI-001',
            'document_revision' => '01',
            'owner_id' => '',
        ]);

        $response->assertSessionHas('success', 'Document owner updated successfully.');
        $this->assertNull(DB::connection('mysql3')->table('masterlist')->where('DOCID', 'WI-001')->value('OWNER_ID'));
    }

    public function test_single_owner_assignment_rejects_documents_outside_sop_and_wi()
    {
        $document = ['DOCID' => 'FORM-001', 'DOCREV' => '01', 'CATID' => 'FORM'];
        $this->insertDocuments([$document]);
        $this->loginAs(1);
        $this->enableQueryLog();

        $response = $this->postSingleOwner([
            'document_id' => 'FORM-001',
            'document_revision' => '01',
            'owner_id' => '2',
        ]);

        $response->assertSessionHas('data', 'Owner update failed. No documents were changed.');
        $this->assertNull(DB::connection('mysql3')->table('masterlist')->value('OWNER_ID'));
        $this->assertCount(0, $this->masterlistUpdateQueries());
    }

    public function test_invalid_single_owner_id_prevents_update()
    {
        $document = ['DOCID' => 'WI-001', 'DOCREV' => '01', 'CATID' => 'WI'];
        $this->insertDocuments([$document]);
        $this->loginAs(1);
        $this->enableQueryLog();

        $response = $this->postSingleOwner([
            'document_id' => 'WI-001',
            'document_revision' => '01',
            'owner_id' => '9999',
        ]);

        $response->assertSessionHas('data', 'Owner update failed. No documents were changed.');
        $this->assertNull(DB::connection('mysql3')->table('masterlist')->value('OWNER_ID'));
        $this->assertCount(0, $this->masterlistUpdateQueries());
    }

    public function test_single_owner_assignment_rejects_missing_document()
    {
        $this->loginAs(1);
        $this->enableQueryLog();

        $response = $this->postSingleOwner([
            'document_id' => 'WI-MISSING',
            'document_revision' => '01',
            'owner_id' => '2',
        ]);

        $response->assertSessionHas('data', 'Owner update failed. No documents were changed.');
        $this->assertCount(0, $this->masterlistUpdateQueries());
    }

    public function test_non_qms_user_is_forbidden_from_single_owner_assignment()
    {
        $document = ['DOCID' => 'WI-001', 'DOCREV' => '01', 'CATID' => 'WI'];
        $this->insertDocuments([$document]);
        $this->loginAs(3);
        $this->enableQueryLog();

        $response = $this->postSingleOwner([
            'document_id' => 'WI-001',
            'document_revision' => '01',
            'owner_id' => '2',
        ]);

        $response->assertStatus(403);
        $this->assertNull(DB::connection('mysql3')->table('masterlist')->value('OWNER_ID'));
        $this->assertCount(0, $this->masterlistUpdateQueries());
    }

    public function test_admin_is_forbidden_from_single_owner_assignment()
    {
        $document = ['DOCID' => 'WI-001', 'DOCREV' => '01', 'CATID' => 'WI'];
        $this->insertDocuments([$document]);
        $this->loginAs(4);
        $this->enableQueryLog();

        $response = $this->postSingleOwner([
            'document_id' => 'WI-001',
            'document_revision' => '01',
            'owner_id' => '2',
        ]);

        $response->assertStatus(403);
        $this->assertNull(DB::connection('mysql3')->table('masterlist')->value('OWNER_ID'));
        $this->assertCount(0, $this->masterlistUpdateQueries());
    }

    private function insertDocuments(array $documents)
    {
        foreach ($documents as $document) {
            DB::connection('mysql3')->table('masterlist')->insert(array_merge([
                'OWNER_ID' => null,
                'INPUTBY' => 'original-inputter',
                'REVISION_DATE' => '2024-01-10',
                'DOCSTATUS' => 'Active',
                'REVIEWED' => 'PENDING',
                'REVIEWED_BY' => 3,
                'REVIEWED_AT' => '2024-01-11 10:00:00',
                'REVIEW_NOTE' => 'existing note',
            ], $document));
        }
    }

    private function loginAs($userId)
    {
        $this->actingAs(User::find($userId));
    }

    private function ownerPayload(array $documents)
    {
        return [
            'bulk_action' => 'owner',
            'owner_id' => '2',
            'selected_documents' => array_map(function ($document) {
                return base64_encode(json_encode([$document['DOCID'], $document['DOCREV']]));
            }, $documents),
        ];
    }

    private function postOwnerPayload(array $payload)
    {
        return $this->postWithCsrf('/document-owner/bulk', $payload);
    }

    private function postSingleOwner(array $payload, array $headers = [])
    {
        return $this->postWithCsrf('/document-owner/single', $payload, $headers);
    }

    private function postReview(array $payload)
    {
        return $this->postWithCsrf('/document-owner/review', $payload, ['HTTP_ACCEPT' => 'application/json']);
    }

    private function postWithCsrf($url, array $payload, array $headers = [])
    {
        $token = 'test-csrf-token';
        $this->withSession(['_token' => $token]);
        $payload['_token'] = $token;
        return $this->post($url, $payload, $headers);
    }

    private function enableQueryLog()
    {
        DB::connection('mysql3')->enableQueryLog();
        DB::connection('mysql3')->flushQueryLog();
    }

    private function masterlistUpdateQueries()
    {
        return array_filter(DB::connection('mysql3')->getQueryLog(), function ($query) {
            return stripos($query['query'], 'update "masterlist"') === 0
                || stripos($query['query'], 'update `masterlist`') === 0;
        });
    }

    private function renderedSummary($content)
    {
        preg_match_all('/<div class="summary-card"><span>(.*?)<\/span><strong>(.*?)<\/strong><\/div>/s', $content, $matches, PREG_SET_ORDER);
        $summary = [];
        foreach ($matches as $match) {
            $summary[trim(strip_tags($match[1]))] = trim(strip_tags($match[2]));
        }
        return $summary;
    }

    private function renderedTableBody($content)
    {
        preg_match('/<tbody>(.*?)<\/tbody>/s', $content, $match);
        return isset($match[1]) ? $match[1] : '';
    }
}
