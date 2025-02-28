@extends('layout')

@section('title', 'Code analyse')

@section('content')

    <h1>Job details</h1>
    <p>Job:</p>
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
                    {{ __('Branch') }}
                </th>
                <th>
                    {{ __('Status') }}
                </th>
                <tr>
                    <td>
                        {{ $job->id }}
                    </td>
                    <td>
                        {{ $job->owner }}
                    </td>
                    <td>
                        {{ $job->repo }}
                    </td>
                    <td>
                        {{ $job->branch }}
                    </td>
                    <td>
                        {{ $job->active }}
                    </td>
                </tr>
            </table>
    <p>Items</p>
            <table>
                <th>
                    {{ __('Bestand') }}
                </th>
                <th>
                    {{ __('Status') }}
                </th>
                <th>
                    {{ __('Resultaat') }}
                </th>
                @foreach($job->items as $item)
                    <tr>
                        <td>
                            {{ $item->path }}
                        </td>
                        <td>
                            {{ $item->status }}
                        </td>
                        @if($item->status == 1 || $item->status == 3)
                            <td>
                                <textarea rows="10" cols="50" name="result{{ $item->id }}">{{ $item->results }}</textarea>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </table>

@endsection