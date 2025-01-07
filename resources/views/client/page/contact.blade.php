@extends('client.layouts.index')


@section('title', '')
{{-- @section('desc', $desc)
@section('keyword', 'al-hasra','smk', 'pendidikan', 'sekolah') --}}

@section('content')
    {{-- Hero --}}
    @include('client.component.contact.contact')
    @include('client.component.contact.office')
    {{-- @include('client.component.landing.contactHome') --}}
@endsection
