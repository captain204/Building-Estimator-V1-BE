<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Estimator extends Model
{
    /** @use HasFactory<\Database\Factories\EstimatorFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'work_items',
        'specifications',
        'to_array',
        'variable',
        'to_html',
        'require_custom_building',
        'other_information',
        'is_urgent',
        'agree',
        'custom_more',
        'classes',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }   

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }


}
