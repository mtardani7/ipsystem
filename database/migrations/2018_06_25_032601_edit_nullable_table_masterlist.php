<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditNullableTableMasterlist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		Schema::table('masterlists', function (Blueprint $table) {
            //
			$table->string('docrem',300)->nullable()->change();
			$table->string('sharestatus',10)->nullable()->change();
			$table->string('saveperiode',50)->nullable()->change();
			$table->string('sortmethode',50)->nullable()->change();
			$table->string('eliminatemethode',50)->nullable()->change();
			$table->string('distribution',50)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
