<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Terrain extends Model
{
    protected $fillable = [
        'name',
        'location',
        'latitude',
        'longitude',
        'price',
        'opening_time',
        'closing_time',
        'image',
        'is_active',
        'manager_id'
    ];

    // 🔗 Relation: Terrain appartient à un manager
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    // 🔗 Relation: Terrain a plusieurs réservations
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
