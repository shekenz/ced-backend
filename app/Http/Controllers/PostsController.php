<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostsController extends Controller
{
    public function __contruct() {
        $this->middleware('auth');
    }

    public function index() {
        $posts = Post::orderBy('created_at', 'DESC')->get();
        return view('posts/index', compact('posts'));
    }

    public function create() {
        return view('posts.create');
    }

    public function store(Request $request) {

        $data = $request->validate([
            'title' => ['required', 'string', 'min:2'],
            'content' => 'required|string',
            'lang' => 'filled', // Default validation. Must be fillable in model.
        ]);

        // To add the connected user_id to the data
        // Auth component -> user connected model -> posts function in user model -> create data
        auth()->user()->posts()->create($data);

        return redirect('/posts');
    }

    public function display($id) {
        $post = Post::findOrFail($id);
        return view('posts/display', compact('post'));
    }

    public function edit(Post $post) {
        return view('posts/edit', compact('post'));
    }

    public function update(Post $post, Request $request) {
        $data = $request->validate([
            'title' => 'required|string|min:2',
            'content' => 'required|string',
        ]);
        
        $post->update($data);
        return redirect(route('posts.display', $post->id));
    }
}
