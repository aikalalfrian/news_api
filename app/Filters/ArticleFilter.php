<?php


namespace App\Filters;

use App\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class ArticleFilter extends AbstractFilter
{
    protected $filters = [
        'topic' => TopicFilter::class,
        'tags' => TagFilter::class,
        'status_article' => StatusFilter::class,
    ];
}
