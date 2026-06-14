<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $fillable = [
        'name', 'description', 'price_per_night',
        'max_occupancy', 'facilities', 'thumbnail',
    ];

    protected function casts(): array
    {
        return [
            'facilities'      => 'array',
            'price_per_night' => 'decimal:2',
        ];
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}