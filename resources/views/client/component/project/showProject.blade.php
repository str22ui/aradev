@extends('client.layouts.index')


@section('title', '')
{{-- @section('desc', $desc)
@section('keyword', 'al-hasra','smk', 'pendidikan', 'sekolah') --}}
<div class="mx-auto bg-gray-100 md:mt-32 px-4 mt-24 pt-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Perumahan di {{ $kota }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($perumahan as $p)
            <div class="bg-white shadow-lg rounded-lg overflow-hidden transform hover:scale-105 transition duration-300">
                <!-- Image Section -->
                <div class="relative">
                    <img class="w-full h-56 object-cover" src="{{ asset('storage/' . $p->images->first()->image_path) }}" alt="Perumahan {{ $p->perumahan }}">
                    @if($p->status === 'Available')
                        <span class="absolute top-2 left-2 bg-green-500 text-white text-sm font-semibold px-3 py-1 rounded-full">Available</span>
                    @elseif($p->status === 'Sold Out')
                        <span class="absolute top-2 left-2 bg-red-500 text-white text-sm font-semibold px-3 py-1 rounded-full">Sold Out</span>
                    @elseif($p->status === 'Soon')
                        <span class="absolute top-2 left-2 bg-blue-500 text-white text-sm font-semibold px-3 py-1 rounded-full">Soon</span>
                    @endif
                </div>
                

                <!-- Content Section -->
                <div class="p-5">
                    <h3 class="text-lg font-semibold text-gray-800">{{ $p->perumahan }}</h3>
                    <p class="text-gray-600 mt-1">{{ $p->lokasi }}, {{ $p->kota }}</p>
                    <div class="mt-2 text-gray-800 font-semibold">
                        <span>Harga Mulai:</span>
                        <span class="text-blue-600">Rp {{ number_format($p->harga, 0, ',', '.') }} {{ $p->satuan }}-an</span>
                    </div>

                    <!-- Keunggulan Section -->
                    @if($p->keunggulan)
                        @php
                            $keunggulan = json_decode($p->keunggulan)
                        @endphp
                        @if (is_array($keunggulan))
                            <ul class="mt-3 text-gray-600 space-y-1 list-none">
                                @foreach(array_slice($keunggulan, 0, 3) as $item)
                                    <li><i class="fas fa-check-circle text-green-500 mr-2"></i>{{ $item }}</li>
                                @endforeach
                                @if (count($keunggulan) > 3)
                                    <li class="text-gray-500 italic">and more...</li>
                                @endif
                            </ul>
                        @endif
                    @endif

                    <!-- Buttons Section -->
                    <div class="mt-4 space-y-2">
                        @if ($p->status === 'Available')
                            <a href="/form/{{ $p->id }}"
                               class="block text-center text-white py-2 px-4 rounded-lg bg-blue-500 hover:bg-blue-700 transition">
                                <i class="fas fa-file-download"></i> Download Pricelist
                            </a>
                            <a href="/formPenawaran/{{ $p->id }}"
                                 class="block text-center text-white py-2 px-4 rounded-lg bg-green-500 hover:bg-green-700 transition">
                            <i class="fas fa-handshake"></i> Penawaran
                        </a>
                        @else
                            <button disabled
                                    class="block text-center w-full text-gray-500 py-2 px-4 rounded-lg bg-gray-300 cursor-not-allowed">
                                <i class="fas fa-file-download"></i> Download Pricelist
                            </button>
                             <button disabled
                                    class="block text-center w-full text-gray-500 py-2 px-4 rounded-lg bg-gray-300 cursor-not-allowed">
                                <i class="fas fa-handshake"></i> Penawaran
                            </button>
                        @endif



                        <a href="/showPerumahan/{{$p->id}}"
                           class="block text-center text-blue-600 underline hover:text-blue-800 transition">
                            <i class="fas fa-info-circle"></i> See More
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
