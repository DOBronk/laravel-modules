<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Show student') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __('Name') }}: {{ $student->name }} <br>
                    {{ __('Date of birth') }}: {{ \Carbon\Carbon::parse($student->dob)->format('d-m-Y') }}<br><br>
                    {{ __('Parents') }}: <br>
                    @forelse($student->parents as $parent)
                        {{ $parent->name }} <br>
                    @empty
                        {{ __('No parents found') }} <br>
                    @endforelse
                    <br>{{ __('Mentors') }}: <br>
                    @forelse($student->mentors() as $mentor)
                        {{ $mentor->name }} <br>
                    @empty
                        {{ __('No mentors found') }} <br>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
