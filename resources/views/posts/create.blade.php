<x-app-layout>
    <x-slot name="title">
        Create Post
    </x-slot>
    <form class="flex flex-col">
        <label class="label-shared lg:text-lg" for="title">{{ __('Title') }} :</label>
        <input class="input-shared" id="title" name="title" type="text">
        <label class="label-shared lg:text-lg" for="content">{{ __('Article') }} :</label>
        <div id="toolbar"></div>
        <textarea id="editor" class="input-shared h-96" name="content"></textarea>
        <input class="button-shared lg:w-24" type="submit">
    </form>
</x-app-layout>