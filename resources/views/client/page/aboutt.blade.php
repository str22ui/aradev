@extends('client.layouts.index')


@section('title', '')
{{-- @section('desc', $desc)
@section('keyword', 'al-hasra','smk', 'pendidikan', 'sekolah') --}}

@section('content')
    {{-- Hero --}}
    @include('client.component.about.about')
    @include('client.component.about.visi')
    {{-- @include('client.component.landing.contactHome') --}}
@endsection
