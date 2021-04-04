<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Dashboard | {{ $title }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-dashboard antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            {{-- <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header ?? ''}}
                </div>
            </header> --}}

            <!-- Page Content -->
            <main>
                <div class="py-2 sm:py-8">
                    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm rounded-md sm:rounded-lg">
                            @if(isset($title))
                            <div class="flex flex-row py-2 px-3 sm:py-4 sm:px-5 bg-white border-b border-gray-200">
                                <h3 class="text-lg flex-none font-bold">
                                    {{ $title }}
                                </h3>
                                <div class="flex-grow"></div>
                                @if(isset($controls))
                                <div id="controls" class="flex-none">
                                    {{ $controls }}
                                </div>
                                @endisset
                            </div>
                            @endif
							<div class="m-4">
                            	{{ $slot ?? ''}}
							</div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
