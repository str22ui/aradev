@extends('client.layouts.index')

@section('title', '')
{{-- @section('desc', $desc)
@section('keyword', 'al-hasra','smk', 'pendidikan', 'sekolah') --}}
<div class="mx-auto bg-gray-100 px-4 mt-24 pt-12">
    <div class="container mx-auto py-12 px-6">
        <!-- Header -->
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Detail Service</h1>

        <!-- Konten Utama -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Gambar Properti -->
            <div class="relative">
                <!-- Gambar Utama -->
                <div class="mb-4">
                    <img
                        class="w-full h-auto object-cover rounded-lg shadow-lg"
                        src="{{ asset('storage/' . $service->image) }}"
                        alt="{{ $service->judul }}">
                </div>
                

                <!-- Thumbnail Scroll -->
                <div class="flex overflow-x-auto space-x-2 py-2" id="thumbnailContainer">
                    @foreach ($service->imagesService as $image)
                        <img class="w-24 h-24 object-cover rounded-lg cursor-pointer hover:opacity-75 transition"
                             src="{{ asset('storage/' . $image->image_path) }}"
                             alt="Thumbnail" onclick="changeImage('{{ asset('storage/' . $image->image_path) }}')">
                    @endforeach
                </div>
            </div>

            <!-- Informasi Properti -->
            <div>
                <h2 class="text-2xl font-semibold text-blue-600 mb-4">{{ $service->judul }}</h2>
                <h2 class="text-xl font-semibold text-gray-700 mb-4">{{ $service->short_desc }}</h2>
                <h2 class="text-lg font-semibold text-gray-700 mb-4">{{ $service->no_hp }}</h2>

                <div class="prose text-gray-600 mb-4">
                    {!! $service->long_desc !!}
                </div>
            </div>
        </div>

        <!-- Tombol -->
        <div class="text-center mt-8">
            <a href="https://wa.me/6287854454888"
               class="inline-block bg-green-500 text-white px-6 py-2 rounded-lg shadow-md hover:bg-green-600 transition">
                <i class="fab fa-whatsapp"></i> Hubungi WA
            </a>
        </div>
    </div>
</div>

<script>
function changeImage(imageSrc) {
    document.getElementById('mainImage').src = imageSrc;
}

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

