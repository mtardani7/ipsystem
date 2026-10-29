<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateDocumentReviewReminderTrackingTable extends Migration
{
    protected $connection = 'mysql3';

    public function up()
    {
        $schema = Schema::connection('mysql3');
        if (!$schema->hasTable('document_review_reminder_tracking')) {
            $schema->create('document_review_reminder_tracking', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->charset = 'latin1';
                $table->collation = 'latin1_swedish_ci';
                $table->string('DOCID', 50);
                $table->string('DOCREV', 50);
                $table->string('REMINDER_CYCLE', 64)->nullable();
                $table->primary(['DOCID', 'DOCREV']);
            });
        }
    }

    public function down()
    {
        // Preserve reminder history when rolling back.
    }
}
