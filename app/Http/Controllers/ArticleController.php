<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

    //
use App\Models\Article;
use App\Http\Resources\Article as ArticleResource;
use App\Http\Resources\ArticleCollection;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Self_;

class ArticleController extends Controller
{
   // private static $rules = [
    //     'title' => 'required|string|unique:articles|max:255',
    //    'body' => 'required',
    //    'category_id' => 'required|exists:categories,id'
    // ];
    private static $messages = [
        'required' => 'El campo :attribute es obligatorio.',
        'body.required' => 'Body no válido'
    ];
    public function index()
    {
        //return new ArticleResource(Article::all());
        //return Article::all();
        //return response()->json(new ArticleCollection(Article::all()), 200);
        return new ArticleCollection(Article::paginate(10));
    }
    public function show(Article $article)
    {
       // return new ArticleResource($article);}
        return response()->json(new ArticleResource($article), 200);
    }
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|unique:articles|max:255',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id'
        ], self::$messages);


        // $validator = Validator::make($request->all(), [
        //     'title' => 'required|string|unique:articles|max:255',
        //     'body' => 'required|string'
        // ]);
        //if ($validator->fails()) {
        //     return response()->json(['error' => 'data_validation_failed',
        //         "error_list"=>$validator->errors()], 400);
        // }


        //$article = Article::create($validatedData);
        $article = Article::create($request->all());
        return response()->json($article, 201);
    }
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|unique:articles,title,'.$article->id.'|max:255',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id'
        ], self::$messages);

        $article->update($request->all());
        return response()->json($article, 200);

    }
    public function delete(Article $article)
    {
        $article->delete();
        return response()->json(null, 204);
    }
}

