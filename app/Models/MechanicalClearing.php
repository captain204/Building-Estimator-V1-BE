<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MechanicalClearing extends Model
{
    /** @use HasFactory<\Database\Factories\MechanicalClearingFactory> */
    use HasFactory;
    protected $fillable = [
        'area_of_land',
        'preliminary_needed',
        'no_of_days',
        'category', // 'non_waterlogged', 'unstable_ground', 'swampy'
    ];
}
