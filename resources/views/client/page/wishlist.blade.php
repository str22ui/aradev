@extends('client.layouts.index')


@section('title', '')
{{-- @section('desc', $desc)
@section('keyword', 'al-hasra','smk', 'pendidikan', 'sekolah') --}}

@section('content')
    {{-- Hero --}}
    @include('client.component.wishlist.index')
    {{-- @include('client.component.landing.contactHome') --}}
@endsection
