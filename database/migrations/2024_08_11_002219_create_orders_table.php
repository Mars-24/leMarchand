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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number',30)->unique();
            $table->json('produits')->default(json_encode([]));
            $table->float('reduction')->default(0)->nullable();
            $table->float('acompte')->default(0)->nullable();
            $table->float('prix_total')->default(0);
            $table->enum('mode_achat',['deal','paiement','acompte'])->default('paiement');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('produit_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
            $table->foreign('produit_id')->references('id')->on('produits')->onDelete('set null');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
