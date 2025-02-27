@extends('client.layouts.index')

@section('title', '')
<div class="mx-auto bg-gray-100 px-4 mt-24 pt-12">
    <div class="container mx-auto py-12 px-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Detail Service</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Gambar Properti -->
            <div class="relative">
                <!-- Gambar Utama -->
                <div class="mb-4">
                    <img id="mainImage" class="md:w-3/4 w-full h-auto md:h-96 cursor-pointer rounded-lg"
                         src="{{ asset('storage/' . $service->imagesService->first()->image_path) }}"
                         alt="Perumahan {{ $service->judul }}"
                         onclick="openModal('{{ asset('storage/' . $service->imagesService->first()->image_path) }}')">
                </div>

                <!-- Thumbnail Scroll -->
                <div class="flex overflow-x-auto space-x-2 py-2">
                    @foreach ($service->imagesService as $image)
                        <img class="w-48 h-48 object-cover rounded-lg cursor-pointer hover:opacity-75 transition"
                             src="{{ asset('storage/' . $image->image_path) }}"
                             alt="Thumbnail"
                             onclick="changeImage('{{ asset('storage/' . $image->image_path) }}')">
                    @endforeach
                </div>
            </div>

            <!-- Informasi Properti -->
            <div>
                <h2 class="text-2xl font-semibold text-blue-600 mb-4">{{ $service->judul }}</h2>
                <h2 class="text-xl font-semibold text-gray-700 mb-4">{{ $service->short_desc }}</h2>

                <div class="prose text-gray-600 mb-4">
                    {!! $service->long_desc !!}
                </div>
            </div>
        </div>

        <div class="text-center mt-8">
            <a href="https://wa.me/6287854454888"
               class="inline-block bg-green-500 text-white px-6 py-2 rounded-lg shadow-md hover:bg-green-600 transition">
                <i class="fab fa-whatsapp"></i> Hubungi WA
            </a>
        </div>
    </div>
</div>

<!-- Modal untuk menampilkan gambar -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden flex justify-center items-center" onclick="closeModal(event)">
    <img id="modalImage" class="max-w-full max-h-[90vh] rounded-lg">
</div>

<script>

let images = [
    @foreach ($service->imagesService as $image)
        "{{ asset('storage/' . $image->image_path) }}",
    @endforeach
];
let currentIndex = 0;

function changeImage(imageSrc) {
    document.getElementById('mainImage').src = imageSrc;
    currentIndex = images.indexOf(imageSrc); // Update index agar tetap sinkron
}

// Fungsi untuk mengganti gambar setiap 3 detik
setInterval(() => {
    currentIndex = (currentIndex + 1) % images.length;
    document.getElementById('mainImage').src = images[currentIndex];
}, 3000);

// Fungsi untuk membuka modal dengan gambar yang diklik
function openModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModal').classList.remove('hidden');
}

// Fungsi untuk menutup modal saat klik di luar gambar
function closeModal(event) {
    const modal = document.getElementById('imageModal');
    if (event.target === modal) {
        modal.classList.add('hidden');
    }
}
</script>


