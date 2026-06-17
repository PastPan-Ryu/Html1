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
        Schema::create('akun_games', function (Blueprint $table) {
            $table->string('id_akun', 50)->primary();
            $table->string('nama_akun', 100);
            $table->string('game', 100);
            $table->integer('level')->nullable();
            $table->string('rank', 50)->nullable();
            $table->integer('harga');
            $table->date('tanggal')->nullable();
            $table->string('penjual', 100)->nullable(); // using username for relation based on old structure
            $table->string('kontak', 50)->nullable();
            $table->string('foto', 255)->nullable();
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['Tersedia', 'Terjual'])->default('Tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akun_games');
    }
};
