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
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __('Messages') }}:
                    @php
                        echo count($messages);
                    @endphp
                    ({{ $unread }} {{ __('new messages') }}) <br><br>
                    <table>
                        <tr>
                            <th>{{ __('Subject') }}</th>
                            <th>{{ __('From') }}</th>
                            <th>{{ __('Message') }}</th>
                            <th>{{ __('Date') }}</th>
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
                                    {{ $message->from_user()->get()->first()->name }}
                                </td>
                                <td>
                                    {{ $message->message }}
                                </td>
                                <td>
                                    {{ $message->created_at }}
                                </td>
                            </tr>
                        @endforeach
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
