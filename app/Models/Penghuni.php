<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penghuni extends Model
{
    use HasFactory;

    protected $table = 'penghuni';

    protected $fillable = [
        'kos_id',
        'jenis_identitas',
        'nomor_identitas',
        'nama_lengkap',
        'pekerjaan',
        'tanggal_masuk',
        'tanggal_keluar',
        'status',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'kos_id' => 'integer',
            'tanggal_masuk' => 'date',
            'tanggal_keluar' => 'date',
        ];
    }

    public function kos(): BelongsTo
    {
        return $this->belongsTo(Kos::class);
    }
}
