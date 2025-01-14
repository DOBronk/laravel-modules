<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __('Actieve opdracht:') }}<br>
                    <table>
                        <th>
                            {{ __('Job id') }}
                        </th>
                        <th>
                            {{ __('Git eigenaar') }}
                        </th>
                        <th>
                            {{ __('Repository') }}
                        </th>
                        <th>
                            {{ __('Status') }}
                        </th>
                        @foreach ($items as $item)
                            <tr>
                                <td>
                                    {{ $item->owner }}
                                </td>
                                <td>
                                    {{ $item->repo }}
                                </td>
                                <td>
                                    {{ $item->path }}
                                </td>
                                <td>
                                    {{ $item->status }}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
