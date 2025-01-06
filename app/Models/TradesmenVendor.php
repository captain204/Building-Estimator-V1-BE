<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradesmenVendor extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'category',
        'sub_category',
        'profile_picture',
        'job_picture',
        'description',
        'email',
        'phone_number',
        'guarantor_name',
        'guarantor_contact_number',
        'guarantor_id_image',
    ];

}
