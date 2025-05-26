<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyPengajuan extends Model
{
    use HasFactory;

    protected $table = 'daily_pengajuan';

    protected $fillable = [
        'tanggal_mulai',
        'tanggal_selesai',
        'cell',
        'id_po',
    ];

    public function po()
    {
        return $this->belongsTo(Po::class, 'id_po');
    }

    public function sizeOrderDailies()
    {
        return $this->hasMany(SizeOrderDaily::class, 'id_daily_pengajuan');
    }

    public function kurangs()
    {
        return $this->hasMany(Kurang::class, 'id_daily_pengajuan');
    }
}
