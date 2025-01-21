@extends('client.layouts.index')

@section('title', '')
<div class="mx-auto  px-6 mt-24 pt-12 bg-gray-100">
    <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Info & Education</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($info as $i)
        <div class="bg-white shadow-lg rounded overflow-hidden border border-gray-200 hover:shadow-xl transition-shadow duration-300">
            <img class="w-full h-56 object-cover" src="{{ asset('storage/' . $i->imagesInfo->first()->image_path) }}" alt="Image">
            <div class="p-4 hover:bg-gray-50">
                <p class="text-sm text-blue-500 font-semibold mb-1">{{ $i->status }}</p>
                <h2 class="text-lg font-bold text-gray-800 mb-2 leading-relaxed">{{ $i->title }}</h2>
                <p class="text-gray-600 mb-2 leading-relaxed">{{ $i->headline }}</p>
                <p class="text-sm text-gray-500 mb-4 flex items-center leading-relaxed">
                    <svg class="w-4 h-4 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 4h10M3 11h18M5 19h14a2 2 0 002-2v-7H3v7a2 2 0 002 2z"/>
                    </svg>
                    Dipublikasikan pada {{ $i->created_at->format('d M Y') }}
                </p>
                <a href="{{ route('info.show', $i->id) }}" class="text-blue-500 mt-2 inline-block">Baca Selengkapnya</a>
            </div>

        </div>
        @endforeach
    </div>
</div>

