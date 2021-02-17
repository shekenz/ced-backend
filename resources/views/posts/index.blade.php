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
                    <th class="hidden md:table-cell">ID</th>
                    <th>Title</th>
                    <th class="hidden md:table-cell">Created at</th>
                    <th class="hidden md:table-cell">Author</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                <tr>
                    <td class="hidden md:table-cell">{{ $post->id }}</td>
                    <td><a href="{{ route('posts.display', $post->id) }}" class="default">{{ $post->title }}</a></td>
                    <td class="hidden md:table-cell">{{ $post->created_at }}</td>
                    <td class="hidden md:table-cell"><a href="{{ route('users.display', $post->user->id) }}" class="default">{{ $post->user->username }}</a></td>
                    <td class="text-right"><a class="button-shared" href="{{ route('posts.edit', $post->id) }}">{{ __('Edit') }}</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
</x-app-layout>