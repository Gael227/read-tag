<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'judul',
        'jumlah_halaman',
        'halaman_terakhir',
        'selesai',
    ];

    protected $casts = [
        'selesai' => 'boolean',
    ];

    /**
     * Relasi ke anotasi-anotasi dari buku ini.
     */
    public function annotates()
    {
        return $this->hasMany(Annotate::class);
    }

    /**
     * Hitung persentase progress membaca.
     */
    public function getProgressPercentageAttribute(): int
    {
        if ($this->jumlah_halaman <= 0) {
            return 0;
        }

        return (int) round(($this->halaman_terakhir / $this->jumlah_halaman) * 100);
    }

    /**
     * Cek apakah buku selesai dibaca.
     */
    public function isFinished(): bool
    {
        return $this->selesai || $this->halaman_terakhir >= $this->jumlah_halaman;
    }
}
