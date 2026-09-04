<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KondisiKuku extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

    public function penyakits()
    {
        return $this->hasMany(Penyakit::class);
    }

    public function rekomendasiPerawatans()
    {
        return $this->hasMany(RekomendasiPerawatan::class);
    }

    public function historis()
    {
        return $this->hasMany(Histori::class);
    }
}
