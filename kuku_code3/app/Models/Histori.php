<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Histori extends Model
{
    use HasFactory;
    protected $table = 'historis';

    protected $fillable = [
        'user_id',
        'nama',
        'usia',
        'kondisi_kuku_id',
        'image_path',
        'prediction',
        'confidence',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kondisiKuku()
    {
        return $this->belongsTo(KondisiKuku::class);
    }

    public function penyakit()
    {
        return $this->belongsTo(\App\Models\Penyakit::class);
    }

    public function rekomendasiPerawatan()
    {
        return $this->belongsTo(\App\Models\RekomendasiPerawatan::class);
    }
}
