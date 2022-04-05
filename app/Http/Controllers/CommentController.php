<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function createComment(Request $request, $id){
        $post = Post::find($id);
        $comment = $post->comments->create($request->all());
        if(!$comment){
            return response()->json(['message' => 'Comment not created'], 422);
        }
            return response()->json([$comment, 'message' => 'comment created successfully'], 201);

    }
}
