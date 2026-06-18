<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'booking_code',
        'room_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'check_in',
        'check_out',
        'total_nights',
        'total_price',
        'status',
        'payment_status',
        'paid_at',
        'handled_by',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'check_in'       => 'date',
            'check_out'      => 'date',
            'total_price'    => 'decimal:2',
            'paid_at'        => 'datetime',
        ];
    }

    // Hitung total termasuk F&B
    public function grandTotal(): float
    {
        $fnbTotal = $this->fnbOrders
            ->whereNotIn('status', ['cancelled'])
            ->sum('total_price');

        return (float) $this->total_price + (float) $fnbTotal;
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function handler()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function fnbOrders()
    {
        return $this->hasMany(FnbOrder::class);
    }

    // Auto-generate booking code
    public static function generateCode(): string
    {
        $date  = now()->format('Ymd');
        $count = self::whereDate('created_at', today())->count() + 1;
        return 'B-' . $date . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
    }
}
