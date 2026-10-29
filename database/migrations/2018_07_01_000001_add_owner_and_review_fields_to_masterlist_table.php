<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOwnerAndReviewFieldsToMasterlistTable extends Migration
{
    protected $connection = 'mysql3';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $schema = Schema::connection('mysql3');

        $schema->table('masterlist', function (Blueprint $table) use ($schema) {
            if (!$schema->hasColumn('masterlist', 'OWNER_ID')) {
                $table->unsignedInteger('OWNER_ID')->nullable()->after('DISTRIBUTION');
            }

            if (!$schema->hasColumn('masterlist', 'REVISION_DATE')) {
                $table->date('REVISION_DATE')->nullable()->after('OWNER_ID');
            }

            if (!$schema->hasColumn('masterlist', 'REVIEWED')) {
                $table->string('REVIEWED', 20)->nullable()->after('REVISION_DATE');
            }

            if (!$schema->hasColumn('masterlist', 'REVIEWED_BY')) {
                $table->unsignedInteger('REVIEWED_BY')->nullable()->after('REVIEWED');
            }

            if (!$schema->hasColumn('masterlist', 'REVIEWED_AT')) {
                $table->dateTime('REVIEWED_AT')->nullable()->after('REVIEWED_BY');
            }

            if (!$schema->hasColumn('masterlist', 'REVIEW_NOTE')) {
                $table->text('REVIEW_NOTE')->nullable()->after('REVIEWED_AT');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Preserve owner and review data if this migration is rolled back.
    }
}
