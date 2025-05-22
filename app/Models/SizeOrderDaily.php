<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SizeOrderDaily extends Model
{
    use HasFactory;

    protected $table = 'size_order_daily';

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
