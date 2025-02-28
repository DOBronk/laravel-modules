@extends('layout')

@section('title', 'Code analyse')

@section('content')
    <h1>Code analyse startpagina</h1>

    @if($items->count() > 0)
        <p>Aangemaakte jobs:</p>
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
                                {{ $item->branch }}
                            </td>
                            <td>
                                {{ count($item->items) }}
                            <td>
                                {{ $item->active }}
                            </td>
                            <td>
                                <a href="{{ route('codeanalyzer.job', ['id' => $item->id]) }}">{{ _('Toon details') }}</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
    @else
    <p>Nog geen jobs aangemaakt</p>
    @endif

    @can('noActiveJobs')
        <p>Er zijn geen actieve jobs, u kunt een nieuwe job toevoegen</p>
        <a href="{{ route('codeanalyzer.create.step.one') }}">Nieuwe job aanmaken</a>
    @else
        <p>Er staat nog een job in de wacht, u kunt geen nieuwe jobs aanmaken</p>
    @endcan

@endsection
