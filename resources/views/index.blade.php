@extends('layouts/base', [
    'title' => 'Home',
])

@section('content')
    <div id=content class="text-gray-700 shadow-lg p-4 m-5 border border-black">
        C'est ici que j'insèrerai ta maquette @esteban &#10084;<br>
    </div>
   
    @foreach ($posts as $post)
    <article class="text-gray-700 shadow-lg p-4 m-5 border border-black">
        <h3>{{ $post->title }}</h3>
        <span>{{ $post->content }}</span>  
    </article>
    @endforeach

@stop