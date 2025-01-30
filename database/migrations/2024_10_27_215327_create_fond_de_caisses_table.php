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
        Schema::create('fond_de_caisses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id'); // Référence de l'utilisateur qui ouvre la caisse
            $table->decimal('montant_initial', 10, 2); // Fond initial
            $table->timestamps();

            // Clé étrangère
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fond_de_caisses');
    }
};
