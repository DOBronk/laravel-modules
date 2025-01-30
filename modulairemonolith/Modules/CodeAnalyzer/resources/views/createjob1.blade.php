@extends('layout')

@section('title', 'Code analyse')

@section('content')

<h1>Code analyse nieuwe job aanmaken</h1>
<p>{{ __('Geef een git repository op') }}</p>
    <form action="{{ route('codeanalyzer.create.step.one.post') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <table>
            <tr>
                <th>Eigenaar</th>
                <td>
                    <input type="text" name="owner" value="{{ old('owner') }}" />
                    <x-input-error :messages="$errors->get('owner')" class="mt-2" />
                </td>
            </tr>
            <tr>
                <th>Repository</th>
                <td>
                    <input type="text" name="repository" value="{{ old('repository') }}"/>
                    <x-input-error :messages="$errors->get('repository')" class="mt-2" />
                </td>
            </tr>
            <tr>
                <th>Branch</th>
                <td><input type="text" name="branch" value="{{ old('branch') }}"/> (Optioneel veld, wanneer niet ingevuld wordt de standaard hoofdbranch gekozen)</td>
            </tr>
            <tr>
                <td colspan="2"><button type="submit">Volgende stap</button></td>
            </tr>
        </table>
        
    </form>

@endsection
