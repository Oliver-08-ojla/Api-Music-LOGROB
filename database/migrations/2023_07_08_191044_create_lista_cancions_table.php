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
        Schema::create('lista_cancions', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');

            $table->foreignId('lista_reproduccion_id')
            ->constrained('lista_reproduccions')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();

            $table->foreignId('cancion_id')
            ->constrained('cancions')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();

            $table->foreignId('user_id')
            ->constrained('users')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lista_cancions');
    }
};
