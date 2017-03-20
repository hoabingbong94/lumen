<?php
namespace App\Http\Controllers;

use App\Post;
use Illuminate\Support\Facades\Input;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{

    public function index(Post $post)
    {
        $post = Post::all();
        $count_post = Post::get()->count();
        if ($count_post) {
            return response()->json($post, 200);
        } else {
            return response()->json('No data', 404);
        }
    }

    public function save(Request $request)
    {
        $post = Post::where('id', '=', Input::get('id'))->first();
        if ($post === null) {
            //create
            $Post = new Post();
            $this->saveData($request,$Post);

        }
        else{
            //update
            $Post = new Post();
           $this->saveData($request,$Post);
        }

    }

    public function saveData(Request $request,Post $post)
    {
        $this->validate($request, [
            'title' => 'required',
            'description_content' => 'required',
            'content_txt' =>'required'
        ]);
        $post->title = $request->title;
        $post->description_content = $request->description_content;
        $post->content = $request->content_txt;
//        dd($post);
        if($post->save())
        {
            $post->id = Input::get('id');
            return response()->json($post,200);
        }
        else{
            return response()->json('Bad request',400);
        }
    }



}