<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchParticipant extends Model
{
    protected $fillable = [
        'match_id',
        'user_id',
        'status',
    ];

    public function match()
    {
        return $this->belongsTo(Matche::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
