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
                    @if (!strlen($roles))
                        {{ __('At this moment you do not have any rights, please contact an administrator to get access to the system.') }}
                    @else
                        Welkom {{ $user->name }}
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            U bent ingelogged als: {{ $roles }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if ($user->hasRole('ROLE_STUDENT') && isset($classes))
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Classes') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            @foreach ($classes as $class)
                                {{ __('Name') }}: {{ $class->name }} {{ __('Year') }} {{ $class->year }}
                                {{ __('Mentor') }}
                                {{ $class->mentor()->name }}
                                <x-nav-link :href="route('class', $class->id)" name="id">{{ __('Show class') }}</x-nav-link>
                                <br>
                            @endforeach
                        </p>
                </div>
            </div>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($user->hasRole('ROLE_MENTOR'))
                        U bent mentor van de volgende klas(sen):<br><br>
                        @forelse ($user->mentorOf()->get() as $class)
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

                    @if ($user->hasRole('ROLE_PARENT'))
                        U bent ouder van de volgende kind(eren):<br><br>
                        @forelse ($user->children()->get() as $class)
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
