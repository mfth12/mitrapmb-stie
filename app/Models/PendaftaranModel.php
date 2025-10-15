<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PendaftaranModel extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';
    protected $primaryKey = 'pendaftaran_id';

    protected $fillable = [
        'user_id',
        'agen_id',
        'id_calon_mahasiswa',
        'username_siakad',
        'password_text', // penambahan plain pswd
        'no_transaksi',
        'prodi_id',
        'prodi_nama',
        'tahun',
        'gelombang',
        'biaya',
        'kelas',
        'nama_lengkap',
        'email',
        'nomor_hp',
        'nomor_hp2',
        'status',
        'keterangan',
        'response_data',
        'synced_at',
    ];

    protected $casts = [
        'biaya' => 'decimal:2',
        'tahun' => 'integer',
        'gelombang' => 'integer',
        'synced_at' => 'datetime',
        'response_data' => 'array',
    ];

    /**
     * Relasi ke user (calon mahasiswa)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Relasi ke agen
     */
    public function agen(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agen_id', 'user_id');
    }

    /**
     * Scope untuk pendaftaran berhasil
     */
    public function scopeSuccess($query)
    {
        return $query->where('status', 'success');
    }

    /**
     * Scope untuk pendaftaran pending
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope untuk pendaftaran gagal
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Accessor untuk status badge
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'success' => '<span class="badge bg-success text-success-fg">Berhasil</span>',
            'failed' => '<span class="badge bg-danger text-danger-fg">Gagal</span>',
            default => '<span class="badge bg-warning text-warning-fg">Pending</span>',
        };
    }

    /**
     * Accessor untuk format biaya
     */
    public function getBiayaFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->biaya, 0, ',', '.');
    }

    /**
     * Accessor untuk nama kelas
     */
    public function getNamaKelasAttribute(): string
    {
        return match ($this->kelas) {
            '0' => 'Reguler Pagi',
            '1' => 'Reguler Sore',
            '2' => 'Malam',
            '3' => 'International',
            '5' => 'Kemitraan',
            default => 'Tidak Diketahui'
        };
    }
}
