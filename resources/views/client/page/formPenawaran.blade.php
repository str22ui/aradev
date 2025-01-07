@extends('client.layouts.index')


@section('title', '')
{{-- @section('desc', $desc)
@section('keyword', 'al-hasra','smk', 'pendidikan', 'sekolah') --}}

@section('content')
    {{-- Hero --}}
    @include('client.component.form.formPenawaran')
    {{-- @include('client.component.contact.office') --}}
    {{-- @include('client.component.landing.contactHome') --}}
@endsection
