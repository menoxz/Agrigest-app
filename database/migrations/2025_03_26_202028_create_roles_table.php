<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
      public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nom_role')->unique();;
            $table->text('description')->nullable();
            $table->timestamps();
        });

        DB::table('roles')->insert([
            'nom_role' => 'agriculteur',
            'description' => 'Role accordé a un agriculteur',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('roles')->insert([
            'nom_role' => 'admin',
            'description' => 'Role accordé a un administrateur',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
