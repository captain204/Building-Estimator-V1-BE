<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabourRates extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'area_of_work',
        'lower_point_daily_rate_per_day',
        'higher_point_daily_rate_per_day',
        'average_point_daily_rate_per_day',
        'unit_of_costing',
        'lower_point_daily_rate_per_unit',
        'higher_point_daily_rate_per_unit',
        'average_point_daily_rate_per_unit'
    ];
}
