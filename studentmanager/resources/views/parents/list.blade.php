<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Studenten lijst') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($parents)
                        <table>
                            <tr>
                                <td style="text-align:left">Naam</th>
                                <td style="text-align:left">Geboortedatum</th>
                                <td style="text-align:left">Email</th>
                                <td style="text-align:left">Telefoon</th>
                            </tr>
                            @foreach ($parents as $parent)
                                <tr>
                                    <td>{{ $parent->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($parent->dob)->format('d-m-Y') }}</td>
                                    <td>{{ $parent->email }}</td>
                                    <td>{{ $parent->phone }}</td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <p>Geen ouders gevonden.</p>
                    @endif

                    <!--            {{ $user->roles()->first()['name'] }} -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
