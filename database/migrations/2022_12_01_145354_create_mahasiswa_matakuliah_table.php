<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa_matakuliah', function (Blueprint $table) {
            // $table->id();
            $table->string('mhsNim');
            $table->unsignedBigInteger('mkId');
            $table->foreign('mhsNim')->references('nim')->on('mahasiswa');
            $table->foreign('mkId')->references('id')->on('matakuliah');
            $table->timestamps();
            $table->primary(['mkId', 'mhsNim']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswa_matakuliah');
    }
};
