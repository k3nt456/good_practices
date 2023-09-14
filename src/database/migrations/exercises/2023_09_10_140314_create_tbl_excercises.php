<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_excercises', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->bigInteger('idmuscles_exercise')->unsigned()->comment('División por musculos');
            $table->bigInteger('iddivision_execution')->unsigned()->comment('División por ejecución(Push/Pull)');
            $table->bigInteger('idspecificity')->unsigned()->comment('Músculo específico o varios músculos');
            $table->text('img_excercise')->comment('Imagen del ejercicio');
            $table->text('vid_excercise')->comment('Video del ejercicio');
            $table->uuid('iduser_added')->comment('Usuario que añadió el alimento');
            $table->uuid('iduser_accepts')->nullable()->comment('Usuario que aceptó el alimento');
            $table->char('status', 1)->default(1)->comment('0:Inactivo, 1:Activo, 2:Eliminado');
            $table->timestamps();

            $table->foreign('idmuscles_exercise')->references('id')->on('tbl_muscles_exercise');
            $table->foreign('iddivision_execution')->references('id')->on('tbl_division_execution_excercises');
            $table->foreign('idspecificity')->references('id')->on('tbl_division_execution_excercises');
            $table->foreign('iduser_added')->references('id')->on('tbl_user');
            $table->foreign('iduser_accepts')->references('id')->on('tbl_user');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_excercises');
    }
};
