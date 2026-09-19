<?php

namespace App\Models;

use App\Traits\MetaDataTrait;
use App\Traits\Sluggable;
use App\Traits\UploadsImageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    use Sluggable, UploadsImageTrait, MetaDataTrait;

    protected $fillable = [
        'title', 'slug', 'description', 'content', 'avatar', 'website_url', 'category', 'technologies', 'client', 'project_year', 'active', 'featured', 'position',
    ];

    protected $casts = [
        'active' => 'boolean',
        'featured' => 'boolean',
        'position' => 'integer',
        'project_year' => 'integer',
    ];

    public function getImageUrlAttribute(): string
    {
        if (!$this->avatar) {
            return asset('assets/imgs/default.png');
        }

        if (str_starts_with($this->avatar, 'assets/') || filter_var($this->avatar, FILTER_VALIDATE_URL)) {
            return asset($this->avatar);
        }

        return Storage::disk('public')->url($this->avatar);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = $this->makeUniqueSlug(
            $value,
            $this->getTable(),
            'slug',
            $this->exists ? $this->id : null
        );
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeOrderByMultipleColumns($query, array $columns, $direction = 'asc')
    {
        foreach ($columns as $column) {
            $query->orderBy($column, $direction);
        }

        return $query;
    }
}
