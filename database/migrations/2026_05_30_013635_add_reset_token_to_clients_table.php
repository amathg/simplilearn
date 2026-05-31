<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('password')->nullable();
            $table->string('reset_token', 100)->nullable();
            $table->timestamp('reset_token_at')->nullable();
        });
    }

    public function down(): void {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['password','reset_token','reset_token_at']);
        });
    }
};