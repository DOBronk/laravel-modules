<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __('Jobs:') }}<br>
                    <table>
                        <th>
                            {{ __('Id') }}
                        </th>
                        <th>
                            {{ __('Eigenaar') }}
                        </th>
                        <th>
                            {{ __('Repository') }}
                        </th>
                        <th>
                            {{ __('Tree') }}
                        </th>
                        <th>
                            {{ __('Aantal items') }}
                        </th>
                        <th>
                            {{ __('Status') }}
                        </th>

                        @foreach ($items as $item)
                            <tr>
                                <td>
                                    {{ $item->id }}
                                </td>
                                <td>
                                    {{ $item->owner }}
                                </td>
                                <td>
                                    {{ $item->repo }}
                                </td>
                                <td>
                                    {{ $item->tree }}
                                </td>
                                <td>
                                    {{ count($item->items) }}
                                <td>
                                    {{ $item->active }}
                                </td>
                                <td>
                                    <a href="">{{ _('Toon details') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
