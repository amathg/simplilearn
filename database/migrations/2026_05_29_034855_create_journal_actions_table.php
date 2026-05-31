<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('journal_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boutique_id')->constrained()->cascadeOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->string('action');
            $table->string('module');
            $table->text('description')->nullable();
            $table->string('ip_address')->nullable();
            $table->json('donnees_avant')->nullable();
            $table->json('donnees_apres')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('journal_actions'); }
};