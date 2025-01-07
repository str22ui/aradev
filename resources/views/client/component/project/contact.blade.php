<div class="grid grid-cols-1 lg:grid-cols-2 p-6 bg-gray-100 mt-12 gap-8">
    <!-- Informasi Kontak -->
    <div class="flex items-center justify-center text-center mb-8 mt-12 md:mt-0">
        <div>
            <h2 class="text-xl font-semibold mb-4">For Further Information</h2>
            <p>Contact Us Via Whatsapp</p>
            <p class="text-lg font-bold mt-2">+62 878 5445 4888</p>
            <a href="https://wa.me/6287854454888" class="inline-block bg-green-500 text-white px-6 py-2 rounded-full mt-4 shadow-md hover:bg-green-600 transition">Chat Now</a>
        </div>
    </div>

    <!-- Lokasi Peta -->
    <div class="bg-gray-200 rounded-lg overflow-hidden shadow-md">
        <iframe
            src="{{ $perumahan->maps }}"
            width="100%"
            height="400"
            frameborder="0"
            style="border:0;"
            allowfullscreen=""
            aria-hidden="false"
            tabindex="0">
        </iframe>
    </div>
</div>
