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
                    @forelse($mentors as $mentor)
                        <tr>
                            <td> Naam: {{ $mentor->name }} </td>
                            <td> Geboortejaar: {{ $mentor->email }} </td>
                            <td> Email: {{ $class->mentor()->name }}</td>
                            <td> Studenten:
                                @forelse ($class->students() as $student)
                                    <br> Naam: {{ $student->name }}
                                @empty
                                    <br> Klas heeft (nog) geen studenten
                                @endforelse
                        </tr>
                    @empty
                        <p>Geen klassen gevonden.</p>
                    @endforelse
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
