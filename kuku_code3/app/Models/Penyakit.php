<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyakit extends Model
{
    use HasFactory;

    protected $fillable = [
        'kondisi_kuku_id',
        'penyakit_name',
        'description',
    ];

    public function kondisiKuku()
    {
        return $this->belongsTo(KondisiKuku::class);
    }
}
