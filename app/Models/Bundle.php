<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'is_active',
    ];

    public function items()
    {
        return $this->hasMany(BundleItem::class);
    }
}
