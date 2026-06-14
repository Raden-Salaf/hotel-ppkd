<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FnbCategory extends Model
{
    protected $fillable = ['name', 'icon'];

    public function menus()
    {
        return $this->hasMany(FnbMenu::class);
    }
}