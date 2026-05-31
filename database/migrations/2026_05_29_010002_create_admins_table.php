<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boutique_id')->constrained('boutiques')->cascadeOnDelete();
            $table->string('login')->unique();
            $table->string('email')->unique();
            $table->string('mot_de_passe');
            $table->enum('role', ['owner','admin','manager'])->default('admin');
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('admins');
    }
};