<x-app-layout>
    <div x-init="Echo.private('messages.{{ Auth::user()->id }}')
        .listen('MessageSent', (event) => {
            console.log(event.message);
            let reply = '{{ route('messages.create') }}' + '?to-user=' + event.message['from_user_id'];
            let show = '{{ route('messages.index') }}' + '/' + event.message['id'] + '/';
            document.getElementById('unread-messages-2').innerHTML = event.unreadMessages;
            document.getElementById('messages').innerHTML = event.countMessages;
            document.getElementById('messages-tbody').innerHTML += '<tr><td>Nieuw extra bericht</td></tr>';
        })">
    </div>

    <style>
        table {
            border-collapse: collapse !important;
        }

        td {
            border: 2px solid #111827 !important;
            position: relative !important;
        }

        tr:hover,
        tr:focus-within {
            background: #111827 !important;
            outline: none !important;
        }

        td>a:first-child {
            display: flex !important;
            padding: 18px !important;
            text-decoration: none !important;
            color: inherit !important;
            z-index: 0 !important;

            &:focus {
                outline: 0 !important;
            }
        }
    </style>

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
                    <strong id="messages">
                        @php
                            echo count($messages);
                        @endphp
                    </strong>
                    (<strong id="unread-messages-2">{{ $unread }}</strong> {{ __('new messages') }}) <br><br>
                    <table style="width: 90%;">
                        <tbody id="messages-tbody">
                            @foreach ($messages as $message)
                                <tr>
                                    <td>
                                        <x-nav-link @style(['color: green !important', 'font-weight: bold !important' => !$message->read])
                                            :href="route('messages.show', $message->id)">{{ $message->subject }}</x-nav-link>
                                    </td>
                                    <td>
                                        <x-nav-link @style(['color: green !important', 'font-weight: bold !important' => !$message->read])
                                            :href="route('messages.show', $message->id)">{{ $message->from_user->name }}</x-nav-link>
                                    </td>
                                    <td>
                                        <x-nav-link @style(['color: green !important', 'font-weight: bold !important' => !$message->read])
                                            :href="route('messages.show', $message->id)">{{ $message->crop_message(50) }}</x-nav-link>
                                    </td>
                                    <td>
                                        <x-nav-link @style(['color: green !important', 'font-weight: bold !important' => !$message->read])
                                            :href="route('messages.show', $message->id)">{{ $message->created_at }}</x-nav-link>
                                    </td>
                                    <td>
                                        <x-nav-link :href="route('messages.create', ['to-user' => $message->from_user->id])">{{ __('Reply') }}</x-nav-link>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
