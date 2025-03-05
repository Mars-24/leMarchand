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
            $table->string('imei')->nullable();
            $table->double('prix_minimum')->default(0);
            $table->integer('quantite')->default(1);
            $table->integer('garantie')->default(1);
            $table->double('stock')->default(1);
            $table->enum('status',['en_stock', 'vendu', 'reserve','reparation','deal','obselete']);
            $table->enum('provenance',['deal','fournisseur'])->default('fournisseur');
            $table->string('code_bar')->unique()->nullable();
            $table->unsignedBigInteger('fournisseur_id');
            $table->unsignedBigInteger('subcategory_id');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('fournisseur_id')->references('id')->on('fournisseurs')->onDelete('cascade');
            $table->foreign('subcategory_id')->references('id')->on('sub_categories')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
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
