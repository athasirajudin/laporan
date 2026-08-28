<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kos extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'wilayah_id',
        'nama_kos',
        'alamat',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'wilayah_id' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class);
    }

    public function penghuni(): HasMany
    {
        return $this->hasMany(Penghuni::class);
    }
}
