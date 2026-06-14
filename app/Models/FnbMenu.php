<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FnbMenu extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'description', 'fnb_category_id',
        'price', 'image', 'status', 'created_by',
    ];

    protected function casts(): array
    {
        return ['price' => 'decimal:2'];
    }

    public function category()
    {
        return $this->belongsTo(FnbCategory::class, 'fnb_category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }
}