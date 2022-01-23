<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;
    protected $fillable=[
        'score',
        'user_id',
        'quiz_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function quiz(){
        return $this->belongsTo(Quiz::class);
    }
    
}
