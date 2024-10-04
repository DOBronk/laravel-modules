<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Message') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __('Subject') }}: {{ $message->subject }}<br>
                    {{ __('Date') }}: {{ $message->created_at }}<br><br>
                    {{ __('Message') }}: <br>
                    <p style="white-space: pre-wrap">{{ $message->message }}</p> <br><br>
                    <x-nav-link :href="route('messages.list')">{{ __('Return to inbox') }}</x-nav-link>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
