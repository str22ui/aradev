@extends('client.layouts.index')


@section('title', '')
{{-- @section('desc', $desc)
@section('keyword', 'al-hasra','smk', 'pendidikan', 'sekolah') --}}

@section('content')
    {{-- Hero --}}
    @include('client.component.project.perumahan')
    @include('client.component.project.deskripsi')
    @include('client.component.project.contact')
    {{-- @include('client.component.landing.contactHome') --}}
@endsection
