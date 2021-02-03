<x-app-layout>
    <x-slot name="title">
        Create Post
    </x-slot>
    <form class="flex flex-col">
        <label class="label-shared" for="title">{{ __('Title') }} :</label>
        <input class="input-shared" id="title" name="title" type="text">
        <label class="label-shared" for="content">{{ __('Article') }} :</label>
        <textarea class="input-shared h-96" name="content"></textarea>
        <input class="button-shared lg:w-24" type="submit">
    </form>
</x-app-layout>