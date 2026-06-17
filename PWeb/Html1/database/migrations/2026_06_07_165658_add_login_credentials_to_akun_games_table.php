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
        Schema::table('akun_games', function (Blueprint $table) {
            $table->string('login_email')->nullable()->after('email_pembeli');
            $table->string('login_password')->nullable()->after('login_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('akun_games', function (Blueprint $table) {
            $table->dropColumn(['login_email', 'login_password']);
        });
    }
};
