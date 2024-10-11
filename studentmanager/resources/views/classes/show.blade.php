<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Class') }}: {{ $class->name }} {{ __('Schoolyear') }}: {{ $class->year }} {{ __('Mentor') }}:
            {{ $class->mentor()->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table>
                        <tr>
                            <td colspan="5"> {{ __('Students') }}: </td>
                        </tr>
                        <tr>
                            @forelse ($class->students()->get() as $student)
                        <tr>
                            <td> {{ __('Name') }}: {{ $student->name }} </td>
                        </tr>
                    @empty
                        <td> {{ __("Class doesn't have (any) students yet") }} </td>
                        @endforelse
                        </tr>
                        </tr>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
