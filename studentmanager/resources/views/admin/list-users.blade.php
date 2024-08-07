<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gebruikerslijst') }}
        </h2>
    </x-slot>
    <form method="post" action="{{ route('admin.users.create', absolute: false) }}">
        @csrf
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <table>
                            <tr>
                                <td style="text-align:left">Naam</td>
                                <td style="text-align:left">Geboortedatum</td>
                                <td style="text-align:left">Email</td>
                                <td style="text-align:left">Telefoon</td>

                                @foreach ($roles as $role)
                                    <td> {{ ucfirst(strtolower(explode('_', $role->name)[1])) }}</td>
                                @endforeach
                            </tr>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }} rooms: {{ count($user->classrooms()->get()) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($user->dob)->format('d-m-Y') }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    @foreach ($roles as $role)
                                        <td>

                                            @if (!$user->hasRole($role->name))
                                                <x-text-input type="checkbox" value="{{ $role->id }}"
                                                    name="roles[roles-{{ $user->id }}][]" />
                                            @else
                                                <x-text-input type="checkbox" value="{{ $role->id }}"
                                                    name="roles[roles-{{ $user->id }}][]" checked />
                                            @endif
                                        </td>
                                    @endforeach
                                    <!-- $user->roles()->attach(1) -->
                                </tr>
                            @endforeach
                        </table>
                        <br>
                        <x-primary-button>Wijzigingen opslaan</x-primary-button>

                    </div>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>
