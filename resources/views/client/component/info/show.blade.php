@extends('client.layouts.index')

@section('title', $info->title)

<div class="mx-auto md:mt-32 px-6 mt-24 pt-12 max-w-4xl">
    <!-- Gambar Berita -->
    <div class="relative">
        <!-- Tombol Navigasi Kiri -->
        <button id="befBtn" class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full z-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        <!-- Container Slider -->
        <div id="slider" class="overflow-hidden w-full max-w-4xl mx-auto">
            <div id="sliderContent" class="flex transition-transform duration-500">
                @foreach ($info->imagesInfo as $image)
                    <div class="min-w-full">
                        <div class="aspect-w-4 aspect-h-3">
                            <img class="w-full h-full object-cover rounded-lg shadow-lg" src="{{ asset('storage/' . $image->image_path) }}" alt="Image">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Tombol Navigasi Kanan -->
        <button id="aftBtn" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full z-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </button>
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

    </div>

    <!-- Tombol Kembali -->
    <div class="mt-8">
        <a href="{{ route('index.info') }}" class="text-blue-500 hover:underline">
            ← Kembali ke Info & Education
        </a>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const slider = document.getElementById('sliderContent');
        const slides = slider.children;
        const totalSlides = slides.length;

        const prevBtn = document.getElementById('befBtn');
        const nextBtn = document.getElementById('aftBtn');

        // Sembunyikan tombol jika gambar <= 1
        if (totalSlides <= 1) {
            prevBtn.style.display = 'none';
            nextBtn.style.display = 'none';
        }

        let currentIndex = 0;

        function updateSliderPosition() {
            const offset = -currentIndex * 100;
            slider.style.transform = `translateX(${offset}%)`;
        }

        prevBtn.addEventListener('click', () => {
            currentIndex = (currentIndex > 0) ? currentIndex - 1 : totalSlides - 1;
            updateSliderPosition();
        });

        nextBtn.addEventListener('click', () => {
            currentIndex = (currentIndex < totalSlides - 1) ? currentIndex + 1 : 0;
            updateSliderPosition();
        });
    });



    </script>

