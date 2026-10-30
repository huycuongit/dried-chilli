<?php

namespace App\Models;

use App\Traits\MetaDataTrait;
use App\Traits\Sluggable;
use App\Traits\HasVietnameseSlug;
use App\Traits\UploadsImageTrait;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use Sluggable, UploadsImageTrait, MetaDataTrait, HasVietnameseSlug;

    protected $table = 'services';

    protected $fillable = ['contract_price', 'name', 'name_vi', 'slug', 'slug_vi', 'description', 'description_vi', 'benefits', 'content', 'content_vi', 'avatar', 'active', 'position'];

    protected $casts = ['contract_price' => 'decimal:2', 'active' => 'boolean', 'position' => 'integer'];

    protected static function booted()
    {
        static::saving(function (Service $service) {
            if (!$service->slug) {
                $name = \Illuminate\Support\Str::substr($service->name, 0, 200);
                $service->slug = $service->makeUniqueSlug($name, $service->getTable(), 'slug', $service->getKey());
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
