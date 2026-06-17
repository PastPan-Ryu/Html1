<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunGame extends Model
{
    use HasFactory;

    protected $table = 'akun_games';
    protected $primaryKey = 'id_akun';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_akun',
        'nama_akun',
        'game',
        'level',
        'rank',
        'harga',
        'tanggal',
        'penjual',
        'kontak',
        'foto',
        'deskripsi',
        'status',
        'pembeli',
        'email_pembeli',
        'login_email',
        'login_password',
    ];
}
