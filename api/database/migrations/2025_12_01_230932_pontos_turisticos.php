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
        Schema::create('pontos_turisticos', function (Blueprint $table) {
            $table->id();

            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->string('cidade');
            $table->string('estado');
            $table->string('pais');

            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->string('endereco')->nullable();

            $table->foreignId('criado_por')
                ->constrained('users')
                ->restrictOnDelete();

            $table->decimal('nota_media', 3, 2)->default(0);

            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pontos_turisticos');
    }
};
