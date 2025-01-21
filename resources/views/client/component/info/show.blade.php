@extends('client.layouts.index')

@section('title', $info->title)

<div class="mx-auto md:mt-32 px-6 mt-24 pt-12 max-w-4xl">
    <!-- Gambar Berita -->
    <div class="mb-6">
        <img class="w-full h-72 object-cover rounded-lg shadow-lg" src="{{ asset('storage/' . $info->imagesInfo->first()->image_path) }}" alt="Image">
    </div>

    <!-- Judul Berita -->
    <h1 class="text-4xl font-bold text-gray-800 mb-2">{{ $info->title }}</h1>

    <!-- Tanggal Publikasi -->
    <p class="text-sm text-gray-500 mb-4">Dipublikasikan pada {{ $info->created_at->format('d M Y') }}</p>

    <!-- Headline -->
    <p class="text-lg text-blue-500 font-semibold mb-4">{{ $info->headline }}</p>

    <!-- Deskripsi Berita -->
    <div class="text-gray-700 leading-relaxed">
        <div class="prose">
            {!! $info->description !!}
        </div>
        <!-- Jika ada tambahan konten -->
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla, ut commodo diam libero vitae erat.
        </p>
    </div>

    <!-- Tombol Kembali -->
    <div class="mt-8">
        <a href="{{ route('index.info') }}" class="text-blue-500 hover:underline">
            ← Kembali ke Info & Education
        </a>
    </div>
</div>
