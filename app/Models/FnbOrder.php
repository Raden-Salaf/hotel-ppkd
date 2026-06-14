<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FnbOrder extends Model
{
    protected $fillable = [
        'order_code', 'booking_id', 'room_number',
        'total_price', 'status', 'handled_by',
    ];

    protected function casts(): array
    {
        return ['total_price' => 'decimal:2'];
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function items()
    {
        return $this->hasMany(FnbOrderItem::class);
    }

    public function handler()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    public static function generateCode(): string
    {
        $date  = now()->format('Ymd');
        $count = self::whereDate('created_at', today())->count() + 1;
        return 'F-' . $date . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
    }
}