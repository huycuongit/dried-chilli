<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'is_sale',
        'is_limited_sale',
        'sale_price',
        'sale_type',
        'sale_start_date',
        'sale_end_date',
        'image',
        'is_active',
        'is_best_seller',
    ];

    /**
     * Get real image URL or fallback to default.
     *
     * @return string
     */
    public function getImageUrlAttribute(): string
    {
        if (!empty($this->image)) {
            return str_starts_with($this->image, 'http') ? $this->image : asset($this->image);
        }
        return asset('images/product_hero.png');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class, 'product_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id')->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Get all image URLs for the product gallery.
     *
     * @return array
     */
    public function getGalleryImagesAttribute(): array
    {
        $urls = [];

        if (!empty($this->image)) {
            $urls[] = $this->image_url;
        }

        if ($this->relationLoaded('images') || $this->images()->exists()) {
            foreach ($this->images as $img) {
                $url = $img->url;
                if (!in_array($url, $urls)) {
                    $urls[] = $url;
                }
            }
        }

        if (empty($urls)) {
            $urls[] = asset('images/product_hero.png');
        }

        return $urls;
    }
}
