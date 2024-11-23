<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    
    protected $fillable = ['question_id', 'type', 'name', 'description', 'question'];

    /**
     * Option belongs to a Question.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Has Many Sub Options.
     */
    
    public function suboptions()
    {
        return $this->hasMany(Suboption::class);
    }
}
