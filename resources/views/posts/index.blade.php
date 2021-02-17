<x-app-layout>
    <x-slot name="title">
        {{ __('Posts') }}
    </x-slot>

    <x-slot name="controls">
        <a href="{{ route('posts.create') }}" class="button-shared">{{ __('New') }}</a>
    </x-slot>

    <div class="m-4">
        <table class="border-collapse table-auto box-border w-full">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Created at</th>
                    <th>Author</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td><a href="{{ route('posts.display', $post->id) }}" class="default">{{ $post->title }}</a></td>
                    <td>{{ $post->created_at }}</td>
                    <td>{{ $post->user->username }}</td>
                    <td><a class="button-shared" href="{{ route('posts.edit', $post->id) }}">{{ __('Edit') }}</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
</x-app-layout>