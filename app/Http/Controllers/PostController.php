<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Image;
use App\Modules\Settings\Models\Forcontact;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            $post = new Post();
            $post->title = $request->title;
            $post->body = $request->body;
            $post->user_id = $user->id;
            $post->save();
            if ($request->structure_id == 0) {
                foreach (Forcontact::all() as $structure) {
                    DB::table('post_structure')->create([
                        'post_id' => $post->id,
                        'structure_id' => $structure->id,
                    ]);
                }
            } else {
                foreach ($request->structure_id as $structure) {

                    DB::table('post_structure')->create([
                        'post_id' => $post->id,
                        'structure_id' => $structure->id,
                    ]);
                }
            }
            if ($request->hasFile('images')) {
                foreach ($request->images as $image) {
                    $image = new Image();
                    $image->post_id = $post->id;
                    $image->path = '';
                    $image->user_id = $user->id;
                    $image->save();
                }
            }

            return redirect()->back();

        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function comment($id, Request $request)
    {
        try{
            $user = Auth::user();
            $comment = new Comment();
            $comment->body = $request->comment;
            $comment->user_id = $user->id;
            $comment->post_id = $id;
            $comment->save();
            return redirect()->back();
        }catch (\Exception $exception){
            throw $exception;
        }
    }

    public function removePost($id)
    {

    }

    public function removeComment($id

    )
    {

    }
}
