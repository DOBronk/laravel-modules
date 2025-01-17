<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __('Geef een git repository op') }}
                    <form action="{{ route('codeanalyzer.create.step.two.post') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{ $repository }}" name="repository" />
                        <input type="hidden" value="{{ $owner }}" name="owner" />

                        <table>
                            @foreach ($items as $item)
                                <tr>
                                    <td>
                                        <x-text-input type="checkbox" name="selectedItems[]" value="{{ $item['sha'] }}|{{ $item['path'] }}"/>
                                    </td>
                                    <td>
                                        {{ $item['path'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                        <x-primary-button>Job aanmaken</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>