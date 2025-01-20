@extends('client.layouts.index')


@section('title', 'Land')
<div class="mx-auto bg-gray-100 md:mt-32 px-6 mt-24 pt-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Land</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($land as $l)
            <div class="bg-white shadow-lg rounded-lg overflow-hidden transform hover:scale-105 transition duration-300 p-4">
                <!-- Image Section -->
                <div class="relative">
                    <img class="w-full h-56 object-cover" src="{{ asset('storage/' . $l->imagesLand->first()->image_path) }}" alt="Perumahan {{ $l->judul }}">
                </div>

                <!-- Content Section -->
                <div class="p-5">
                    <!-- Judul dan Lokasi -->
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $l->judul }}</h3>
                    </div>
                    <p class="text-gray-600">Lokasi: {{ $l->lokasi }}</p>
                    <p class="text-sm text-gray-500 mt-2">
                        LT: {{ $l->lt }} m² | Harga: Rp{{ number_format($l->harga, 0, ',', '.') }} |
                        Surat: {{ $l->surat }} | LMB/PBG: {{ $l->lmb_pbg }}
                    </p>
                    <p class="text-sm text-gray-500 mt-2">
                        Kecamatan: {{ $l->kecamatan }} | Kota: {{ $l->kota }}
                    </p>
                    <p class="text-sm text-gray-500 mt-4">Posted: {{ $l->created_at->format('d/m/y') }}</p>

                    <!-- Buttons Section -->
                    <div class="mt-4 space-y-2">
                        <a href="/showLand/{{$l->id}}"
                           class="block text-center text-blue-600 underline hover:text-blue-800 transition">
                            <i class="fas fa-info-circle"></i> See More
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
