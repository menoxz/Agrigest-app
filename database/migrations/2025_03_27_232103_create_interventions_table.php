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
       Schema::create('interventions', function (Blueprint $table) {
            $table->id();
            $table->enum('type_intervention', ['Semis', 'Arrosage', 'Fertilisation', 'Traitement', 'Récolte']);
            $table->date('date_intervention');
            $table->text('description')->nullable();
            $table->float('qte_produit')->nullable();
            $table->timestamps();
            //les clés étrangères
            $table->foreignId('parcelle_id')->constrained('parcelles');
            $table->foreignId('type_intervention_id')->constrained('type_interventions');
            $table->foreignId('user_id')->constrained('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interventions');
    }
};
