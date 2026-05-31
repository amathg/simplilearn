<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('slug')->unique();
            $table->decimal('prix_mensuel', 10, 2)->default(0);
            $table->decimal('prix_annuel', 10, 2)->default(0);
            $table->integer('nb_produits')->default(100);
            $table->integer('nb_employes')->default(3);
            $table->integer('nb_magasins')->default(1);
            $table->boolean('ecommerce')->default(false);
            $table->boolean('comptabilite')->default(false);
            $table->boolean('rh')->default(false);
            $table->boolean('multi_depot')->default(false);
            $table->boolean('api_access')->default(false);
            $table->boolean('actif')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('plans');
    }
};