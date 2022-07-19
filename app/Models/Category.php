<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $table = 'category';

    protected $fillable = [
        'name',
        'slug',
    ];


    // One to Many (Inverse) 1 data category bisa memiliki banyak data berita
    public function berita()
    {
        return $this->hasMany(Berita::class);
    }
}
