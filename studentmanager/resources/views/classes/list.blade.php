<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Klassenlijst') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @forelse($classes as $class)
                        Schoolklas: {{ $class->name }}
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Leerjaar: {{ $class->year }} Mentor: {{ $class->mentor()->name }}
                        </p>
                        <br>
                        <table>
                            <tr>
                                <td colspan=3> Studenten: </td>
                            </tr>
                            @forelse ($class->students()->get() as $student)
                                <tr>
                                    <td colspan=3> {{ $student->name }} </td>
                                </tr>
                            @empty
                                <tr>
                                    <td columnspan=3> Klas heeft (nog) geen studenten </td>
                                </tr>
                            @endforelse
                            </tr>
                        </table><br>
                    @empty
                        <p>Geen klassen gevonden.</p>
                    @endforelse

                    <br>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
