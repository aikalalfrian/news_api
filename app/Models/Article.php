<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


use App\Filters\ArticleFilter;


class Article extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'topic', 'image', 'tags', 'file_path', 'created_at', 'updated_at'];

    public function scopeFilter(Builder $builder, $request)
    {
        return (new ArticleFilter($request))->filter($builder);
    }
}
