<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostTracker extends Model
{
    /** @use HasFactory<\Database\Factories\CostTrackerFactory> */
    use HasFactory;

    protected $fillable = ['name', 'details', 'quantity', 'price'];

}
