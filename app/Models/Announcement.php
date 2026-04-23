<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'match_id',
        'user_id',
        'content'
    ];

    public function match(){
        return $this->belongsTo(Matche::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    } 
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
