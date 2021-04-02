<x-app-layout>
    <x-slot name="title">
        {{ __('Books') }}
    </x-slot>

    <x-slot name="controls">
        <a href="#" class="button-shared">{{ __('New') }}</a>
    </x-slot>

    <div class="m-4">
        <table class="border-collapse table-auto box-border w-full">
            {{-- <thead>
            </thead> --}}
            <tbody>
                @foreach($books as $book)
                <tr>
                    <td class="hidden md:table-cell">{{ $book->id }}</td>
                    <td><a href="#" class="default">{{ $book->title }}</a></td>
                    <td class="hidden md:table-cell">{{ $book->created_at->diffForHumans() }}</td>
                    <td class="hidden md:table-cell"><a href="#" class="default">{{ $book->user_id }}</a></td>
                    <td class="text-right"><a class="button-shared" href="#">{{ __('Edit') }}</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
</x-app-layout>