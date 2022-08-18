<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class CommentsController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required|string|max:1000',
        ]);
        if (!$validator->passes()) {
            return response()->json(['status' => false, 'error' => $validator->errors()->all()], 400);
        }
        $comment = Comment::create([
            'user_id' => Auth::id(),
            'film_id' => $request->film_id,
            'comment' => $request->comment,
        ]);
        return response()->json([
            'message' => 'Comment added successfully.',
            'comment' => new CommentResource($comment)
        ], 201);
    }
}
