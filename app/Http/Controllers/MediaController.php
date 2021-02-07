<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medium;

class MediaController extends Controller
{
    public function __contruct() {
        $this->middleware('auth');
    }
    //
    public function index(){
        return view('media/index');
    }

    public function create() {
        return view('media/create');
    }

    public function store() {
        $data = request()->validate([
            'name' => ['max:64'],
            'file' => ['required', 'file', 'mimes:jpg,gif,png', 'max:512'],
        ]);
        
        // if name is empty, use original filename;
        if(!$data['name']) {
            $data['name'] = $data['file']->getClientOriginalName();;
        }

        $data['filename'] = request('file')->hashName();
        request('file')->store('uploads', 'public');
        
        auth()->user()->media()->create($data);

        return redirect('/media');
    }

    public function display($id) {
        $medium = Medium::findOrFail($id);
        return view('media/display')->with('medium', $medium);
    }
}
