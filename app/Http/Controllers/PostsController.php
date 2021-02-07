<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Post;

class PostsController extends Controller
{
    public function __contruct() {
        $this->middleware('auth');
    }
    //
    public function create() {
        return view('posts.create');
    }

    public function store() {

        $data = request()->validate([
            'title' => ['required', 'min:2'],
            'content' => 'required',
            'lang' => 'filled', // Default validation. Must be fillable in model.
        ]);

        // To add the connected user_id to the data
        // Auth component -> user connected model -> posts function in user model -> create data
        auth()->user()->posts()->create($data);

        return redirect('/posts');
    }

    public function display($id) {
        $post = Post::findOrFail($id);
        return view('posts/display')->with('post', $post);
    }
}
