@extends('client.layouts.index')

@section('title', '')

@section('content')
    {{-- Hero --}}
    @include('client.component.landing.heroo')
    @include('client.component.landing.project')
    @include('client.component.landing.contactHome')
    @include('client.component.landing.secondary')
    @include('client.component.landing.bank')
    @include('client.component.landing.wishlist')
    <div class="fixed bottom-6 right-6 z-50">
        <!-- Tooltip -->
        <div id="wa-tooltip" class="absolute -top-16 right-0 bg-white p-3 rounded-lg shadow-lg text-gray-800 text-sm w-52 flex justify-between items-center transition-opacity duration-300 opacity-100">
            <span>Hi! 👋 Kamu bisa menghubungi kami via WhatsApp</span>
            <button onclick="closeTooltip()" class="ml-2 text-gray-500 hover:text-gray-800">&times;</button>
        </div>

        <!-- Tombol WhatsApp (Tidak Pernah Hilang) -->
        <a href="https://wa.me/6287854454888" target="_blank" class="relative block">
            <img src="{{ asset('img/asset/logo-wa.png') }}" alt="WhatsApp" class="md:w-14 md:h-14 w-10 h-10">
        </a>
    </div>

@endsection
<script>
    function closeTooltip() {
        const tooltip = document.getElementById('wa-tooltip');
        tooltip.classList.add('opacity-0'); // Animasi fade out
        setTimeout(() => {
            tooltip.style.display = 'none'; // Sembunyikan tooltip setelah animasi
        }, 300); // Sesuaikan dengan durasi animasi
    }

   // Munculkan tooltip saat halaman dimuat
   document.addEventListener("DOMContentLoaded", function () {
        setTimeout(() => {
            const tooltip = document.getElementById('wa-tooltip');
            tooltip.style.opacity = '1'; // Animasi fade in
        }, 500); // Delay munculnya tooltip
    });

    // Cek ukuran layar dan sesuaikan tooltip
    function checkScreenSize() {
        const tooltip = document.getElementById('wa-tooltip');
        if (window.innerWidth <= 768) {
            tooltip.classList.add('w-44', 'text-xs');
            tooltip.style.display = 'flex'; // Pastikan tetap muncul
        } else {
            tooltip.classList.remove('w-44', 'text-xs');
        }
    }

    window.addEventListener('resize', checkScreenSize);
    checkScreenSize();
</script>
