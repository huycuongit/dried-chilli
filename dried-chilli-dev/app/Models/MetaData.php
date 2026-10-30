<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetaData extends Model
{
    protected $table = "meta_data";

    protected $fillable = [
        'meta_key',
        'object_id',
        'title',
        'title_vi',
        'description',
        'description_vi',
        'key_words',
        'key_words_vi'
    ];
}
