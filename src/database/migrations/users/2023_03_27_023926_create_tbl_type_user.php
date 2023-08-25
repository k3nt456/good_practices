<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_type_user', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->char('status', 1)->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_type_user');
    }
};
