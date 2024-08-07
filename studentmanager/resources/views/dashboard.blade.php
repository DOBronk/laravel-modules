<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Hoofdmenu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (!count($user->roles()->get()))
                        U heeft op dit moment nog geen rechten, neem contact op met een administrator om toegang tot het
                        systeem toegewezen te krijgen.
                    @else
                        Welkom {{ $user->name }}, u bent momenteel ingelogged als:
                        @php($array = [])
                        @if ($user->hasRole('ROLE_STUDENT'))
                            @php(array_push($array, 'Student'))
                        @endif
                        @if ($user->hasRole('ROLE_MENTOR'))
                            @php(array_push($array, 'Mentor'))
                        @endif
                        @if ($user->hasRole('ROLE_PARENT'))
                            @php(array_push($array, 'Ouder'))
                        @endif
                        {{ implode(', ', $array) }}
                    @endif
                    <br><br>
                    @if ($user->hasRole('ROLE_STUDENT'))
                        U zit in de volgende klas(sen):<br>
                        @foreach ($user->classrooms()->get() as $class)
                            Naam: {{ $class->name }} Jaar {{ $class->year }} Mentor {{ $class->mentor()->name }}
                            <x-nav-link href="{{ route('class.show') }}"> Toon klas </x-nax-link>
                        @endforeach
                        <br><br>
                    @endif
                    @if ($user->hasRole('ROLE_MENTOR'))
                        U bent mentor van de volgende klas(sen):<br>
                        @forelse ($user->mentors() as $class)
                            @if ($class->mentor()->id == $user->id)
                                Naam: {{ $class->name }} Jaar {{ $class->year }} Mentor
                                {{ $class->mentor()->name }}
                            @endif
                        @empty
                            U bent momenteel geen mentor van een klas.
                        @endforelse
                        <br>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
