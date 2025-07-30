<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('equipe_employe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employe_id')->constrained()->onDelete('cascade');
            $table->foreignId('equipe_id')->constrained()->onDelete('cascade');

            $table->date('date_affectation')->nullable(); // Date à laquelle l'employé a rejoint cette équipe
            $table->date('date_fin')->nullable();         // Date de fin s’il a quitté cette équipe

            $table->timestamps();

            // Pour éviter les doublons (même employé dans la même équipe au même moment)
            $table->unique(['employe_id', 'equipe_id', 'date_affectation']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipe_employe');
    }
};
