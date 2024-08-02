    @if (auth()->check())
        <script>
            window.location.replace("{{ route('dashboard') }}")
        </script>
    @endif
    @extends('template')
    @section('content')
        <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Student Manager</h1>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Welkom bij het student manager project van dennis. U ben't
            nog niet ingelogged, om gebruik te kunnen maken van
            deze
            applicatie
            dient u in te loggen.</p><br>
        <x-nav-link href="{{ route('login') }}">Inloggen</x-nav-link> <x-nav-link
            href="{{ route('register') }}">Registeren</x-nav-link>
    @endsection
