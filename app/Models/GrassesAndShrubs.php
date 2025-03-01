<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrassesAndShrubs extends Model
{
    /** @use HasFactory<\Database\Factories\GrassesAndShrubsFactory> */
    use HasFactory;

    protected $fillable = [
        'qty_area',
        'unit',
        'rate',
        'amount',
        'no_of_days'
    ];
}
