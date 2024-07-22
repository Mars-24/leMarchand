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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->double('prix_achat')->default(0);
            $table->double('prix_vente')->default(0);
            $table->integer('quantite')->default(0);
            $table->integer('garantie');
            $table->enun('status',['en_stock', 'vendu', 'reserve','reparation','deal']);
            $table->unsignedBigInteger('fournisseur_id');
            $table->unsignedBigInteger('subcategory_id');
            $table->foreign('fournisseur_id')->references('id')->on('fournisseurs')->onDelete('cascade');
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
