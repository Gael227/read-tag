<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annotate extends Model
{
    protected $fillable = [
        'book_id',
        'catatan',
        'halaman',
        'tags',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
