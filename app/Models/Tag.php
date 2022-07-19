<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public $table = 'tag';

    protected $fillable = [
        'name',
        'slug',
    ];

    // relasi Many to Many=> yang artinya 1 data tags bisa memiliki banyak berita dan 1 data berita bisa memiliki banyak tags.
    public function berita()
    {
        return $this->hasMany(Berita::class);
    }
}
