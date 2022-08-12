<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Article;
use App\Http\Resources\ArticleResource;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('status_article', '!=', 'deleted')->get();
        return response()->json(['data' => ArticleResource::collection($articles)]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'tags' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'image' => 'required|image:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        if (!$request->hasFile('image')) {
            return response()->json(['upload_file_not_found'], 400);
        }
        $file = $request->file('image');

        if (!$file->isValid()) {
            return response()->json(['invalid_file_upload'], 400);
        }
        $path = public_path() . '/uploads/images/store/';

        $articles = Article::create([
            'name' => $request->name,
            'tags' => $request->tags,
            'topic' => $request->topic,
            'image' => $path . $file->getClientOriginalName(),
        ]);

        return response()->json(['data' => $articles, 'message' => 'Article Created Successfully']);
    }

    public function show($id)
    {
        $articles = Article::where('status_article', '!=', 'deleted')->find($id);

        if (is_null($articles)) {
            return response()->json(['error' => 404, 'message' => 'Article not found'], 404);
        }

        return response()->json(['data' => new ArticleResource($articles)]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'tags' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'image' => 'required|image:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $articles = Article::where('status_article', '!=', 'deleted')->find($id);
        if (is_null($articles)) {
            return response()->json(['error' => 404, 'message' => 'Article not found'], 404);
        }

        if (!$request->hasFile('image')) {
            return response()->json(['upload_file_not_found'], 400);
        }
        $file = $request->file('image');

        if (!$file->isValid()) {
            return response()->json(['invalid_file_upload'], 400);
        }
        $path = public_path() . '/uploads/images/store/';

        $articles->update([
            'name' => $request->name,
            'tags' => $request->tags,
            'topic' => $request->topic,
            'image' => $path . $file->getClientOriginalName(),
        ]);

        return response()->json(['Article Updated Successfully', new ArticleResource($articles)]);
    }

    public function destroy($id)
    {
        $articles = Article::find($id);
        if (is_null($articles)) {
            return response()->json(['error' => 404, 'message' => 'Article not found'], 404);
        }
        $articles->status_article = 'deleted';
        $articles->save();

        return response()->json(['data' => 'Article Deleted Successfully']);
    }

    public function draft($id)
    {
        $articles = Article::find($id);
        if (is_null($articles)) {
            return response()->json(['error' => 404, 'message' => 'Article not found'], 404);
        }
        $articles->status_article = 'draft';
        $articles->save();

        return response()->json(['data' => 'Article Drafted Successfully']);
    }
}
