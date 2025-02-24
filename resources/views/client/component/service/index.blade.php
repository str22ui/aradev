

    <div class="container mx-auto px-4 py-32">
        <h2 class="text-3xl font-bold text-center mb-8">Our Services</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach ($service as $serv)
            <a href="{{ route('showService', ['id' => $serv->id]) }}" class="block">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden h-4/5 transform transition-transform duration-300 hover:scale-105 hover:pointer">
                <!-- Gambar -->
                <div class="relative">
                    <img class="w-full h-full object-cover" src="{{ asset('storage/' . $serv->imagesService->first()->image_path) }}" alt="Perumahan {{ $serv->judul }}">
                    <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-60"></div>
                </div>

                <!-- Konten -->
                <div class="p-4 absolute bottom-0 text-white">
                <h3 class="text-lg font-bold">{{ $serv->judul }}</h3>
                <p class="text-sm">{{ Str::limit($serv->short_desc, 100) }}</p>
            </div>
        </div>
    </a>
        @endforeach
    </div>
</div>


{{-- <div class="container mx-auto px-4 py-32">
    <h2 class="text-3xl font-bold text-center mb-8">Our Services</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach ($service as $serv)
        <div class="bg-white shadow-lg rounded-lg overflow-hidden h-[600px] flex flex-col">
            <!-- Gambar -->
            <div class="h-2/3 w-full">
                <img class="w-full h-full object-cover" src="{{ asset('storage/' . $serv->imagesService->first()->image_path) }}" alt="Perumahan {{ $serv->judul }}">
            </div>

            <!-- Konten -->
            <div class="h-1/3 p-4 flex flex-col justify-center bg-gray-900 text-white">
                <h3 class="text-lg font-bold">{{ $serv->judul }}</h3>
                <p class="text-sm">{{ Str::limit($serv->short_desc, 100) }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div> --}}
