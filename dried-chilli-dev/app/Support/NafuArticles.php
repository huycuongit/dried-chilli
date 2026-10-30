<?php
namespace App\Support;

use App\Models\News;
use Illuminate\Support\Collection;

class NafuArticles
{
    public static function samples(): Collection
    {
        return collect(config('nafu-articles'))->map(function (array $data, int $index) {
            $article = new News;
            $article->setRawAttributes($data + ['id' => 'nafu-' . ($index + 1), 'created_at' => $data['publish_time'], 'author_name' => 'Nafu Home Care']);
            $article->setRelation('meta', null);
            return $article;
        });
    }
}
