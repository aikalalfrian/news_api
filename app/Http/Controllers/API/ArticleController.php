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
        $articles = Article::where('status_article', '=', 'active')->get();
        return response()->json([ArticleResource::collection($articles), 'Article Fetched Successfully']);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'tags' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $fileName = $image->getClientOriginalName();
                $image_encod = base64_encode(file_get_contents($image));
                $destinationPath = config('app.fileDesinationPath') . '/' . $fileName;
                $image->move($destinationPath, $fileName);

                $data = new Article();
                $data->image_name = $image_encod;
                $data->save();
            }
        }

        $articles = Article::create([
            'name' => $request->name,
            'tags' => $request->tags,
            'topic' => $request->topic,
            'image' => $request->image,
        ]);

        return response()->json(['Article Created Successfully', new ArticleResource($articles)]);
    }

    public function show($id)
    {
        $articles = Article::where('status_article', '=', 'active')->find($id);

        if (is_null($articles)) {
            return response()->json('Article not found', 404);
        }
        return response()->json([new ArticleResource($articles)]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'tags' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $fileName = $image->getClientOriginalName();
                $image_encod = base64_encode(file_get_contents($image));
                $destinationPath = config('app.fileDesinationPath') . '/' . $fileName;
                $image->move($destinationPath, $fileName);

                $data = new Article();
                $data->image_name = $image_encod;
                $data->save();
            }
        }

        $articles = Article::where('status_article', '=', 'active')->find($id);
        if (is_null($articles)) {
            return response()->json('Article not found', 404);
        }

        $articles->update($request->all());
        return response()->json(['Article Updated Successfully', new ArticleResource($articles)]);
    }

    public function destroy($id)
    {
        $articles = Article::find($id);
        if (is_null($articles)) {
            return response()->json('Article not found', 404);
        }
        $articles->status_article = 'inactive';
        $articles->save();
        return response()->json(['Article Deleted Successfully']);
    }
}
