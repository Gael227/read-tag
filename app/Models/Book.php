<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'judul',
        'jumlah_halaman',
    ];

    public function annotates()
    {
        return $this->hasMany(Annotate::class);
    }
}
