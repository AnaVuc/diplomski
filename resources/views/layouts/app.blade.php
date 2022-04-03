<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- User permissons --}}
    @if (Auth::check())
        <meta name="userHasPermission" content="{{ auth()->user()->availablePermissions() }}">
    @else <meta name="userHasPermission" content="[]">
    @endif



    <title>{{ config('app.name', 'Diplomski') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    @if (Auth::check())
        <meta name="user_id" content="{{ Auth::user() }}" />
    @endif

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css')  }}" rel="stylesheet">
</head>
<body>
    <div id="app" class="bg-gray-700">

        <main class=" min-h-screen flex flex-col bg-cover w-full ">
            @if (!Route::is('login') && !Route::is('register'))
                <div class="flex top-0 z-50 sticky bg-opacity-60 bg-gray-600">
                    @include('navbar')
                </div>
            @endif
            <div class="flex-1 ">
                @yield('content')
            </div>
            <div class="relative w-full inset-x-0 bottom-0">
                @include('footer')
            </div>

         </main>
    </div>
</body>
</html>
