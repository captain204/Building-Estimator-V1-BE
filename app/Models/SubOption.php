<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubOption extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'option_id',
        'name',
        'type',
        'description',
        'question',
        'is_required',
    ];

    /**
     * SubOption belongs to an Option.
     */
    public function option()
    {
        return $this->belongsTo(Option::class);
    }

}
