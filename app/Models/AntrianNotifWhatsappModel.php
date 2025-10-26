<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AntrianNotifWhatsappModel extends Model
{
    protected $table = 'v2_antrian_notif_whatsapps';
    protected $primaryKey = 'antrian_id';
    protected $casts = [
        'status' => 'integer',
    ];
    protected $fillable = [
        'user_id',
        'sesi',
        'target',
        'tipe',
        'isi_pesan',
        'status',
    ];

    public const PENDING    = 0; // pending (akan terus dicoba).
    public const SUKSES     = 1; // sukses, alhamdulillah
    public const GAGAL      = 2; // gagal sekali, tapi kita langsung reset ke 0 pending supaya ikut diproses lagi.
    public const DEAD       = 3; // dead letter (sudah lewat batas retry, perlu dicek manual).
}
