<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terrain extends Model
{
    use HasFactory;
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
    ];

    protected $casts = [
        'price' => 'float',
        'is_active' => 'boolean',
        'opening_time' => 'datetime:H:i',
        'closing_time' => 'datetime:H:i',
    ];

    // 🔗 Relation: Terrain appartient à un manager
    public function manager()
    {
        return $this->belongsTo(User::class);
    }

    // 🔗 Relation: Terrain a plusieurs réservations
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
