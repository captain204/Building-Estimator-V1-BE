<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialPriceList extends Model
{
    use HasFactory;
    protected $fillable = [
        'price_group',
        'material',
        'specification',
        'size',
        'low_price_point',
        'higher_price_point',
        'average_price_point',
    ];

}
