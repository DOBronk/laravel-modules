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

                    <form method="POST" action="{{ route('messages.store') }}">
                        @csrf
                        <table>
                            <tr>
                                <td>{{ __('To') }}:</td>
                                <td>{{ $to_user->name }}</td>
                            </tr>
                            <tr>
                                <input type="hidden" name="to_user_id" value={{ $to_user->id }} />
                                <td>{{ __('Subject') }}:</td>
                                <td><x-text-input name="subject" class="block mt-1 w-full" type="text" /></td>
                            </tr>
                            <tr>
                                <td>Message</td>
                            </tr>
                            <tr>
                                <td colspan=2><x-text-input name="message" class="block mt-1 w-full" type="text"
                                        style="height: 250px;" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <x-primary-button class="ms-4">Send message</x-primary-button>
                                </td>
                            </tr>
                        </table>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
