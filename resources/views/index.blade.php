@extends('layouts/base', [
    'title' => 'Home',
])

@section('content')
    <div id=content class="text-gray-700 shadow-lg p-4 m-5 border border-black">
        C'est ici que j'insèrerai ta maquette @esteban &#10084;<br>
    </div>
    @foreach(Auth::user()->posts as $post)
        <div class="text-gray-700 shadow-lg p-4 m-5 border border-black">
            <h4>{{ $post['title'] }}</h4>
            <span>{{ $post['content'] }}</span>
        </div>
    @endforeach
@stop