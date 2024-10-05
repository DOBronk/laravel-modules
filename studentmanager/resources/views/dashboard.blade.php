<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (!count($user->roles()->get()))
                        {{ __('At this moment you do not have any rights, please contact an administrator to get access to the system.') }}
                    @else
                        Welkom {{ $user->name }}, u bent momenteel ingelogged als:
                        @php($array = [])
                        @if (Auth::user()->hasRole('ROLE_STUDENT'))
                            @php(array_push($array, 'Student'))
                        @endif
                        @if (Auth::user()->hasRole('ROLE_MENTOR'))
                            @php(array_push($array, 'Mentor'))
                        @endif
                        @if (Auth::user()->hasRole('ROLE_PARENT'))
                            @php(array_push($array, 'Ouder'))
                        @endif
                        @if (Auth::user()->hasRole('ROLE_ADMIN'))
                            @php(array_push($array, 'Administrator'))
                        @endif
                        {{ implode(', ', $array) }}
                    @endif

                    <br><br>
                    @if (Auth::user()->hasRole('ROLE_STUDENT'))
                        U zit in de volgende klas(sen):<br><br>
                        @forelse (Auth::user()->classrooms()->get() as $class)
                            {{ __('Name') }}: {{ $class->name }} {{ __('Year') }} {{ $class->year }}
                            {{ __('Mentor') }}
                            {{ $class->mentor()->name }}
                            <x-nav-link :href="route('class', $class->id)" name="id">{{ __('Show class') }}</x-nav-link>
                            <br>
                        @empty
                            U bent momenteel geen student van een klas.<br>
                        @endforelse
                        <br>
                    @endif

                    @if (Auth::user()->hasRole('ROLE_MENTOR'))
                        U bent mentor van de volgende klas(sen):<br><br>
                        @forelse (Auth::user()->mentorOf()->get() as $class)
                            {{ __('Name') }}: {{ $class->name }} {{ __('Year') }} {{ $class->year }}
                            {{ __('Mentor') }}
                            {{ $class->mentor()->name }}
                            <x-nav-link :href="route('class', $class->id)" name="id">{{ __('Show class') }}</x-nav-link>
                            <br>
                        @empty
                            U bent momenteel geen mentor van een klas.<br>
                        @endforelse
                        <br>
                    @endif

                    @if (Auth::user()->hasRole('ROLE_PARENT'))
                        U bent ouder van de volgende kind(eren):<br><br>
                        @forelse (Auth::user()->children()->get() as $class)
                            {{ __('Name') }}: {{ $class->name }}
                            <x-nav-link :href="route('student.show', $class->id)">{{ __('Show student') }}</x-nav-link>
                            <br>
                        @empty
                            U bent momenteel geen ouder van een kind.<br>
                        @endforelse
                        <br>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
