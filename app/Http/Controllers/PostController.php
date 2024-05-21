<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{

    public function store(Request $request)
    {
     $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
    ]);


    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

        $post = new Post();
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->user_id = auth()->id();
        $post->save();

        return response()->json(['message' => 'Post created successfully'], 201);
    }



 public function update(Request $request, $id)
 {

     $post = Post::find($id);


     if (!$post || $post->user_id !== auth()->id()) {
         return response()->json(['message' => 'Post not found or unauthorized'], 404);
     }


     $validator = Validator::make($request->all(), [
         'title' => 'required|string|max:255',
         'content' => 'required|string',
     ]);


     if ($validator->fails()) {
         return response()->json($validator->errors(), 422);
     }


     $post->title = $request->input('title');
     $post->content = $request->input('content');
     $post->save();

     return response()->json(['message' => 'Post updated successfully'], 200);
 }


     public function destroy($id)
     {

         $post = Post::find($id);


         if (!$post || $post->user_id !== auth()->id()) {
             return response()->json(['message' => 'Post not found or unauthorized'], 404);
         }


         $post->delete();

         return response()->json(['message' => 'Post deleted successfully'], 200);
     }



    public function index()
    {
        $posts = Post::where('user_id', auth()->id())->get();
        return response()->json($posts);
    }
}
