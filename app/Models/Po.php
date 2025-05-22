<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Po extends Model
{
    use HasFactory;

    protected $table = 'po';

    protected $fillable = [
        'no_po',
        'wide',
        'size_run',
        'colour_way',
        'style',
        'market',
        'qty_original',
    ];

    public function dailyPengajuans()
    {
        return $this->hasMany(DailyPengajuan::class, 'id_po');
    }

    public function sizeOrderPos()
    {
        return $this->hasMany(SizeOrderPo::class, 'id_po');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($po) {
            $po->sizeOrderPos()->delete();
        });
    }
}
