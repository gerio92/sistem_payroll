<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToSlipGaji extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('slip_gaji', function (Blueprint $table) {
        $table->foreign('karyawan_id')->references('id')->on('karyawan')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('slip_gaji', function (Blueprint $table) {
        $table->dropForeign(['karyawan_id']);
    });
}
}
