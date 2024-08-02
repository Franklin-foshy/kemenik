<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rompecabezas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('imagen')->nullable();
            $table->foreignId('nivel_id')->constrained('nivels')->onDelete('cascade');
            $table->smallInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rompecabezas');
    }
};
