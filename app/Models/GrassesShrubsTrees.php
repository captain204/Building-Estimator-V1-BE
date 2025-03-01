<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrassesShrubsTrees extends Model
{
    /** @use HasFactory<\Database\Factories\GrassesShrubsTreesFactory> */
    use HasFactory;
    
    protected $fillable = [
        'qty_area',
        'unit',
        'rate',
        'amount',
        'no_of_days'
    ];
}
