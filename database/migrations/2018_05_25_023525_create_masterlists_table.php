<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		Schema::create('masterlists', function (Blueprint $table) {
			$table->increments('id');
            $table->string('docid',20);
			$table->string('docrev',20);
			$table->string('docdesc',100);
			$table->string('docrem',300);
			$table->string('docstatus',10);
			$table->string('divid',50);
			$table->string('catid',50);
			$table->string('pdfview',200);
			$table->string('pdfprint',200);
			$table->string('sharestatus',10);
			$table->string('saveperiode',50);
			$table->string('sortmethode',50);
			$table->string('eliminatemethode',50);
			$table->string('distribution',50);
			$table->string('inputby',50);
			$table->timestamps();
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
