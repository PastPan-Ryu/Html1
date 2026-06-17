<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Convert existing single filename strings to JSON arrays
        DB::table('akun_games')
            ->whereNotNull('foto')
            ->get()
            ->each(function ($akun) {
                // If it's already a JSON array, skip
                $decoded = json_decode($akun->foto, true);
                if (!is_array($decoded)) {
                    DB::table('akun_games')
                        ->where('id_akun', $akun->id_akun)
                        ->update(['foto' => json_encode([$akun->foto])]);
                }
            });

        Schema::table('akun_games', function (Blueprint $table) {
            $table->text('foto')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('akun_games', function (Blueprint $table) {
            $table->string('foto', 255)->nullable()->change();
        });
    }
};
