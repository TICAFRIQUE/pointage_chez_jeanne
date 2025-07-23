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
        Schema::create('parametres', function (Blueprint $table) {
            $table->id();
            //socials links
            $table->longText('lien_facebook')->nullable();
            $table->longText('lien_instagram')->nullable();
            $table->longText('lien_twitter')->nullable();
            $table->longText('lien_linkedin')->nullable();
            $table->longText('lien_tiktok')->nullable();

            //infos application
            $table->string('nom_projet')->nullable();
            $table->longText('description_projet')->nullable();
            $table->string('contact1')->nullable();
            $table->string('contact2')->nullable();
            $table->string('contact3')->nullable();
            $table->string('email1')->nullable();
            $table->string('email2')->nullable();
            $table->string('localisation')->nullable();
            $table->longText('google_maps')->nullable();
            $table->string('siege_social')->nullable();

            //Security
            $table->enum('mode_maintenance', ['up', 'down'])->default('up');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parametres');
    }
};
