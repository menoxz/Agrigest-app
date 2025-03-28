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
        Schema::create('parcelles', function (Blueprint $table) {
            $table->id();
            $table->string('nom_parcelle');
            $table->float('superficie');
            $table->string('type_culture');
            $table->date('date_plantation');
            $table->string('statut');
            $table->timestamps();

            $table->foreignId('type_culture_id')->constrained('type_cultures');


    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parcelles');
    }
};
