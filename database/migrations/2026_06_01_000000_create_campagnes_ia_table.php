<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('campagnes_ia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boutique_id')->constrained()->cascadeOnDelete();
            $table->string('titre');
            $table->text('description')->nullable();
            $table->enum('reseau', ['instagram', 'facebook', 'tiktok', 'tous']);
            $table->enum('type_contenu', ['post', 'story', 'video', 'carousel']);
            $table->text('prompt_utilisateur')->nullable();
            $table->longText('contenu_genere')->nullable();
            $table->string('image_url')->nullable();
            $table->enum('statut', ['brouillon', 'programme', 'publie', 'echoue'])->default('brouillon');
            $table->timestamp('publie_at')->nullable();
            $table->timestamp('programme_at')->nullable();
            $table->json('metriques')->nullable(); // likes, vues, clics
            $table->foreignId('admin_id')->constrained('admins')->cascadeOnDelete();
            $table->timestamps();
        });

        // Ajouter agent_ia au plan
        Schema::table('plans', function (Blueprint $table) {
            $table->boolean('agent_ia')->default(false)->after('api_access');
            $table->integer('nb_campagnes_ia')->default(0)->after('agent_ia');
        });

        // Tokens réseaux sociaux par boutique
        Schema::create('social_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boutique_id')->constrained()->cascadeOnDelete();
            $table->enum('reseau', ['instagram', 'facebook', 'tiktok']);
            $table->string('compte_nom')->nullable();
            $table->string('compte_id')->nullable();
            $table->text('access_token')->nullable();
            $table->timestamp('token_expire_at')->nullable();
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('social_tokens');
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['agent_ia', 'nb_campagnes_ia']);
        });
        Schema::dropIfExists('campagnes_ia');
    }
};