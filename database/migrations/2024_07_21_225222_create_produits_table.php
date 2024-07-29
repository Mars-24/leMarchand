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
            $table->string('photo')->nullable();
            $table->double('prix_achat')->default(0);
            $table->double('prix_vente')->default(0);
            $table->double('prix_minimum')->default(0);
            $table->integer('quantite')->default(0);
            $table->integer('garantie');
            $table->enum('status',['en_stock', 'vendu', 'reserve','reparation','deal']);
            $table->string('code_bar')->unique()->nullable();
            $table->unsignedBigInteger('fournisseur_id');
            $table->unsignedBigInteger('subcategory_id');
            $table->foreign('fournisseur_id')->references('id')->on('fournisseurs')->onDelete('cascade');
            $table->foreign('subcategory_id')->references('id')->on('sub_categories')->onDelete('cascade');
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
