<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FnbOrderItem extends Model
{
    protected $fillable = [
        'fnb_order_id', 'fnb_menu_id',
        'quantity', 'unit_price', 'subtotal', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'unit_price' => 'decimal:2',
            'subtotal'   => 'decimal:2',
        ];
    }

    public function order()
    {
        return $this->belongsTo(FnbOrder::class, 'fnb_order_id');
    }

    public function menu()
    {
        return $this->belongsTo(FnbMenu::class, 'fnb_menu_id');
    }
}