<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    
    protected $fillable = ['category_id', 'text', 'type', 'step'];

    public function category()
    {
        return $this->belongsTo(EstimateCategory::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

}
