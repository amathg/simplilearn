<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('produits', function (Blueprint $table) {
            $table->string('code_produit')->nullable()->after('id');
            $table->string('code_barres')->nullable()->after('code_produit');
            $table->foreignId('marque_id')->nullable()->after('categorie_id');
            $table->decimal('tva', 5, 2)->default(0)->after('promo');
            $table->integer('stock_minimum')->default(5)->after('tva');
            $table->string('unite')->default('pièce')->after('stock_minimum');
            $table->foreignId('fournisseur_id')->nullable()->after('unite');
        });
    }
    public function down(): void {
        Schema::table('produits', function (Blueprint $table) {
            $table->dropColumn(['code_produit','code_barres','marque_id','tva','stock_minimum','unite','fournisseur_id']);
        });
    }
};