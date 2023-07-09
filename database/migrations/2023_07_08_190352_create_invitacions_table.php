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
        Schema::create('invitacions', function (Blueprint $table) {
            $table->id();
            $table->boolean('estado')->default(0);

            $table->foreignId('usuario_invitado_id')
            ->constrained('users')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();

            $table->foreignId('usuario_invitador_id')
            ->constrained('users')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();

            $table->foreignId('lista_reproduccion_id')
            ->constrained('lista_reproduccions')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();




        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitacions');
    }
};
