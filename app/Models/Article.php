<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $guarded = [];

    // public const STATUS = [
    //     'draft' => 0,
    //     'published' => 1,
    //     'deleted' => 2,
    // ];
}
