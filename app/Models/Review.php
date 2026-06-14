<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'booking_id', 'guest_name', 'rating',
        'comment', 'admin_reply', 'replied_by',
        'replied_at', 'is_published',
    ];

    protected function casts(): array
    {
        return [
            'replied_at'   => 'datetime',
            'is_published' => 'boolean',
        ];
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function repliedBy()
    {
        return $this->belongsTo(User::class, 'replied_by');
    }
}