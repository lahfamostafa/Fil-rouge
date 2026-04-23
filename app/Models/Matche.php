<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matche extends Model
{
    protected $fillable = [
        'reservation_id',
        'creator_id',
        'max_players',
        'description',
        'status'
    ];

    protected $casts = [
        'max_players' => 'integer',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function participants()
    {
        return $this->hasMany(MatchParticipant::class, 'match_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function announcement()
    {
        return $this->hasOne(Announcement::class);
    }
}
