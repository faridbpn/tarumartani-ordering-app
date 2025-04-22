<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Kolom yang dapat diisi secara massal
    protected $fillable = ['name'];

    // Relasi ke MenuItem (opsional, jika diperlukan)
    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }
}