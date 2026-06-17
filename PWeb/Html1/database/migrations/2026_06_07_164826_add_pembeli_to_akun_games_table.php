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
            $table->string('pembeli', 100)->nullable()->after('penjual');
            $table->string('email_pembeli')->nullable()->after('pembeli');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('akun_games', function (Blueprint $table) {
            $table->dropColumn(['pembeli', 'email_pembeli']);
        });
    }
};
