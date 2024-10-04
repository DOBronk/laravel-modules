<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Parent list') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($parents)
                        <table>
                            <tr>
                                <td style="text-align:left">{{ __('Name') }}</td>
                                <td style="text-align:left">{{ __('Date of birth') }}</td>
                                <td style="text-align:left">{{ __('Email') }}</td>
                                <td style="text-align:left">{{ __('Phone') }}</td>
                                <td></td>
                            </tr>
                            @foreach ($parents as $parent)
                                <tr>
                                    <td>{{ $parent->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($parent->dob)->format('d-m-Y') }}</td>
                                    <td>{{ $parent->email }}</td>
                                    <td>{{ $parent->phone }}</td>
                                    <td>
                                        <form method="post" action="{{ route('parent.show', absolute: false) }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $parent->id }}">
                                            <x-primary-button>{{ __('View parent') }}</x-primary-button>
                                        </form>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <p>{{ __('No parents found') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
