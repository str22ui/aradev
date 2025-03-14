@extends('client.layouts.index')

@section('title', '')
<div class="mx-auto bg-gray-100 px-6 mt-24 pt-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Detail Tanah</h1>

    <!-- Konten -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Gambar Properti -->
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
                    @foreach ($land->imagesLand as $image)
                    @section('gambar', asset('storage/' . $image->image_path))
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


        <!-- Informasi Properti -->
        <div>
            <h2 class="text-2xl font-semibold text-blue-600 mb-4">{{ $land->judul }}</h2>

            <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                <table class="table-auto w-full text-sm">
                    <tbody class="divide-y divide-gray-300">
                        <tr>
                            <td class="font-semibold text-gray-700">Luas Tanah</td>
                            <td class="text-gray-600">{{ $land->lt }} m²</td>
                        </tr>
                        <tr>
                            <td class="font-semibold text-gray-700">Surat</td>
                            <td class="text-gray-600">{{ $land->surat }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold text-gray-700">IMB/PBG</td>
                            <td class="text-gray-600">{{ $land->imb }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold text-gray-700">Harga</td>
                            <td class="text-gray-600">Rp {{ number_format($land->harga, 0, ',', '.') }}/m²</td>
                        </tr>
                        <tr>
                            <td class="font-semibold text-gray-700">Lokasi</td>
                            <td class="text-gray-600">{{ $land->lokasi }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold text-gray-700">Kecamatan</td>
                            <td class="text-gray-600">{{ $land->kecamatan }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold text-gray-700">Kota</td>
                            <td class="text-gray-600">{{ $land->kota }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="prose text-gray-600 mb-4">
                {!! $land->deskripsi !!}
            </div>
            @if(isset($embedUrl))
                <!-- Video -->
                <h2 class="text-lg font-semibold text-gray-800 mt-6">Ingin tahu lebih lengkap? Yuk, tonton video YouTube kami!</h2>
                <div class="mt-4">
                    <iframe
                        src="{{ $embedUrl }}"
                        frameborder="0"
                        allowfullscreen
                        class="rounded-lg shadow-lg md:w-3/4 w-full h-60 lg:h-80">
                    </iframe>
                </div>
            @endif
        </div>
    </div>

    <!-- Tombol -->
    <div class="text-center mt-8">
        <a href="https://wa.me/6287854454888"
           class="inline-block bg-green-500 text-white px-6 py-2 rounded-lg shadow-md hover:bg-green-600 transition">
            <i class="fab fa-whatsapp"></i> Hubungi WA
        </a>
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
