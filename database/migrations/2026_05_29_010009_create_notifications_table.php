<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boutique_id')->constrained('boutiques')->cascadeOnDelete();
            $table->string('titre');
            $table->text('message')->nullable();
            $table->enum('type', ['commande','stock','paiement','alerte','info','system'])->default('info');
            $table->string('lien')->nullable();
            $table->boolean('lue')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('notifications'); }
};