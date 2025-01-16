@extends('client.layouts.index')

@section('title', '')
<div class="mx-auto bg-gray-100 md:mt-32 px-6 mt-24 pt-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Property Secondary</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($secondary as $s)
            <div class="bg-white shadow-lg rounded-lg overflow-hidden transform hover:scale-105 transition duration-300 p-4">
                <!-- Image Section -->
                <div class="relative">
                    <img class="w-full h-56 object-cover" src="{{ asset('storage/' . $s->images->first()->image_path) }}" alt="Perumahan {{ $s->perumahan }}">
                    @if($s->status === 'Available')
                        <span class="absolute top-2 left-2 bg-green-500 text-white text-sm font-semibold px-3 py-1 rounded-full">Available</span>
                    @elseif($s->status === 'Sold Out')
                        <span class="absolute top-2 left-2 bg-red-500 text-white text-sm font-semibold px-3 py-1 rounded-full">Sold Out</span>
                    @elseif($s->status === 'Soon')
                        <span class="absolute top-2 left-2 bg-blue-500 text-white text-sm font-semibold px-3 py-1 rounded-full">Soon</span>
                    @endif
                </div>

                <!-- Content Section -->
                <div class="p-5">
                    <!-- Kota dan Status -->
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $s->kota }}</h3>
                        <!-- Status badge yang sejajar dengan kota -->
                        @if($s->status === 'Available')
                            <span class="bg-green-500 text-white text-sm font-semibold px-3 py-1 rounded-full lg:hidden">Available</span>
                        @elseif($s->status === 'Sold Out')
                            <span class="bg-red-500 text-white text-sm font-semibold px-3 py-1 rounded-full lg:hidden">Sold Out</span>
                        @elseif($s->status === 'Soon')
                            <span class="bg-blue-500 text-white text-sm font-semibold px-3 py-1 rounded-full lg:hidden">Soon</span>
                        @endif
                    </div>
                    <p class="text-gray-600">{{ $s->secondary }}</p>
                    <p class="text-sm text-gray-500 mt-2">
                        LB: {{ $s->luas_bangunan }} | LT: {{ $s->luas_tanah }} |
                        <i class="fas fa-bed"></i> {{ $s->kamar_tidur }} |
                        <i class="fas fa-shower"></i> {{ $s->kamar_mandi }} |
                        <i class="fas fa-car"></i> {{ $s->garasi }}
                    </p>
                    <p class="text-sm text-gray-500 mt-4">Posted: {{ $s->created_at->format('d/m/y') }}</p>

                    <!-- Buttons Section -->
                    <div class="mt-4 space-y-2">
                        <a href="/showPerumahan/{{$s->id}}"
                           class="block text-center text-blue-600 underline hover:text-blue-800 transition">
                            <i class="fas fa-info-circle"></i> See More
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
