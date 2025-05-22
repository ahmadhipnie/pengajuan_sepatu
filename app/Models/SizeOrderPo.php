<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SizeOrderPo extends Model
{
    use HasFactory;

    protected $table = 'size_order_po';

    protected $fillable = [
        'size',
        'total',
        'id_po',
    ];

    public function po()
    {
        return $this->belongsTo(Po::class, 'id_po');
    }
}
