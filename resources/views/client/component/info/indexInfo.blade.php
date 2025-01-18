@extends('client.layouts.index')

@section('title', '')
<div class="mx-auto md:mt-32 px-6 mt-24 pt-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Info & Education</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($info as $i)
        <div class="bg-white shadow rounded overflow-hidden">
            <img class="w-full h-56 object-cover" src="{{ asset('storage/' . $i->imagesInfo->first()->image_path) }}" alt="Image">
            <div class="p-4">
                <p class="text-sm text-blue-500 font-semibold">{{ $i->status }}</p>
                <h2 class="text-lg font-bold">{{ $i->title }}</h2>
                <p class="text-gray-600">{{ $i->headline }}</p>
                <a href="#" class="text-blue-500 mt-2 inline-block">Baca Selengkapnya</a>
                <a href="{{ route('info.show', $i->id) }}" class="text-blue-500 mt-2 inline-block">Baca Selengkapnya</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
