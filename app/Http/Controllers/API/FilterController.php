<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Resources\FilterResource;


class FilterController extends Controller
{
    public function filter(Request $request)
    {
        $articles = Article::filter($request)->get();

        return response()->json(['data' => FilterResource::collection($articles)]);
    }
}
