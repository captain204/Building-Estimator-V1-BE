<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallRequest extends Model
{
    /** @use HasFactory<\Database\Factories\CallRequestFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'phone',
        'response',
    ];
}
