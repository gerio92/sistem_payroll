<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropKaryawanAndRelatedData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('karyawan', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop foreign key constraints from absensi table
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropForeign('absensi_karyawan_id_foreign');
        });

        // Drop foreign key constraints from gaji table
        Schema::table('gaji', function (Blueprint $table) {
            $table->dropForeign('gaji_karyawan_id_foreign');
        });

        // Drop the karyawan table
        Schema::dropIfExists('karyawan');
    }
}
