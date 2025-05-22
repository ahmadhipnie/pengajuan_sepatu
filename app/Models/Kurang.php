<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurang extends Model
{
    use HasFactory;

    protected $table = 'kurang';

    protected $fillable = [
        'size',
        'total',
        'id_daily_pengajuan',
    ];

    public function dailyPengajuan()
    {
        return $this->belongsTo(DailyPengajuan::class, 'id_daily_pengajuan');
    }
}
