<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('ventes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boutique_id')->constrained('boutiques')->cascadeOnDelete();
            $table->foreignId('client_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->string('reference')->unique();
            $table->enum('statut', ['en_attente','confirmee','prete','livree','annulee'])->default('en_attente');
            $table->decimal('total_ht', 10, 2)->default(0);
            $table->decimal('total_tva', 10, 2)->default(0);
            $table->decimal('total_ttc', 10, 2)->default(0);
            $table->enum('canal', ['pos','boutique_en_ligne','telephone','autre'])->default('pos');
            $table->enum('mode_paiement', ['sur_place','orange_money','wero','carte'])->default('sur_place');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('ventes'); }
};