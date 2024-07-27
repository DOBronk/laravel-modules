@extends('template')
@section('title', 'Studenten')
@section('content')


<h1>Studenten Manager</h1>


<h1>Studenten lijst</h1>
@forelse($persons as $person)
    <tr>
        <td>{{ $person->first_name }}</td>
        <td>{{ $person->last_name }}</td>
        <td>{{ $person->dob }}</td>
        <td>{{ $person->email }}</td>
        <td>{{ $person->phone }}</td>
    </tr>
@empty
    <p>Geen studenten gevonden.</p>
@endforelse
</table>

@endsection