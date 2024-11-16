<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'firstname',
        'lastname',
        'country',
        'builder_type',
        'phone',
        'birthdate',
        'bio',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
