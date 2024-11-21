<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateCategoryOption extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',     
        'name',            
        'type',            
        'options',         
        'description',     
    ];

    protected $casts = [
        'options' => 'array', 
    ];

    public function category()
    {
        return $this->belongsTo(EstimateCategory::class, 'category_id');
    }

}
