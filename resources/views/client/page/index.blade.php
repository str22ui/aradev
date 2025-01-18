@extends('client.layouts.index')

@section('title', '')

@section('content')
    {{-- Hero --}}
    @include('client.component.landing.heroo')
    @include('client.component.landing.project')
    @include('client.component.landing.contactHome')
    @include('client.component.landing.secondary')
    @include('client.component.landing.bank')
@endsection
