<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Message Inbox') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($sent)
                        <div role="alert" class="alert alert-info">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                class="h-6 w-6 shrink-0 stroke-current">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ __('Message sent') }}</span>
                        </div>
                    @endif

                    {{ __('Messages') }}:
                    @php
                        echo count($messages);
                    @endphp
                    ({{ $unread }} {{ __('new messages') }}) <br><br>
                    <table style="width: 90%;">
                        <tr>
                            <th>{{ __('Subject') }}</th>
                            <th>{{ __('From') }}</th>
                            <th>{{ __('Message') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                        @foreach ($messages as $message)
                            <tr>
                                <td>
                                    @if ($message->read == 0)
                                        <b><x-nav-link :href="route('messages.show', $message->id)"
                                                style="color: white; font-weight: 900">{{ $message->subject }}</x-nav-link></b>
                                    @else
                                        <x-nav-link :href="route('messages.show', $message->id)">{{ $message->subject }}</x-nav-link>
                                    @endif
                                </td>
                                <td>
                                    {{ $message->from_user->name }}
                                </td>
                                <td>
                                    {{ $message->crop_message(50) }}
                                </td>
                                <td>
                                    {{ $message->created_at }}
                                </td>
                                <td>
                                    <x-nav-link :href="route('messages.create') . '?to-user=' . $message->from_user->id">{{ __('Reply') }}</x-nav-link>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
