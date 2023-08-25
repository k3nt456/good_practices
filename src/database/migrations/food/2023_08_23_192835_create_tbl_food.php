<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_food', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->integer('amount')->default(100)->comment('Cantidad por defecto');
            $table->decimal('kcal', 6, 3)->comment('Calorías');
            $table->decimal('protein', 6, 3)->comment('Proteínas');
            $table->decimal('fat', 6, 3)->comment('Grasas');
            $table->decimal('hydrates', 6, 3)->comment('Hidratos');
            $table->uuid('iduser_added')->comment('Usuario que añadió el alimento');
            $table->uuid('iduser_accepts')->nullable()->comment('Usuario que aceptó el alimento');

            $table->char('status', 1)->default(1)->comment('0:Inactivo, 1:Activo, 2:Eliminado');
            $table->timestamps();

            $table->foreign('iduser_added')->references('id')->on('tbl_user');
            $table->foreign('iduser_accepts')->references('id')->on('tbl_user');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_food');
    }
};
