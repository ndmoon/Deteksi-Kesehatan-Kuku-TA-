<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekomendasiPerawatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kondisi_kuku_id',
        'recommendation',
    ];

    public function kondisiKuku()
    {
        return $this->belongsTo(KondisiKuku::class);
    }
}
