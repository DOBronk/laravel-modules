@extends('codeanalyzer::layouts.master')

@section('content')
    <h1>Hello World</h1>
    <script>
        const rabbit = require("rabbitmq-stream-js-client")
    </script>
    <p>Module: {!! config('codeanalyzer.name') !!}</p>
    <p>API URI: {!! config('codeanalyzer.api_uri') !!}</p>
@endsection
