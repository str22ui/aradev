<div data-aos="fade-up" data-aos-duration="1000" class="mx-auto mt-24 py-6 ">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-semibold text-gray-800 text-center mb-6">Wishlist Aradev</h2>


        <div class="grid grid-cols-1 gap-6 max-w-3xl mx-auto">
            @foreach($wishlist as $w)
            <div class="bg-white shadow-md rounded-lg p-6 border-l-8
                @if($w->status == 'Available') border-green-500
                @elseif($w->status == 'Closed') border-red-500
                @elseif($w->status == 'Remove') border-gray-500
                @endif">

                <!-- Nama & Status dalam satu baris -->
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-gray-900">{{$w->nama}}</h3>
                    <span class="px-3 py-1 text-white font-semibold text-sm rounded
                        @if($w->status == 'Available') bg-green-500
                        @elseif($w->status == 'Closed') bg-red-500
                        @elseif($w->status == 'Remove') bg-gray-500
                        @endif">
                        {{$w->status}}
                    </span>
                </div>

                <p class="text-gray-700 mt-3"><strong>Permintaan:</strong> {{$w->permintaan}} {{$w->jenis}}</p>
                <p class="text-gray-600 text-sm mt-1">🏙 Lokasi: {{$w->lokasi}}</p>
                <p class="text-green-600 font-semibold mt-2 text-lg">💰 Harga: Rp {{ ($w->harga_budget) }}</p>
                <p class="text-gray-600 mt-4 leading-relaxed">{!! $w->keterangan !!}</p>
            </div>
            @endforeach
        </div>
    </div>

    <div class="flex mx-auto justify-center gap-6 mt-8">
        <div>
            <a href="/wishlist" class="px-6 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 transition">
                <i class="fas fa-info-circle"></i> More Detail
            </a>
        </div>
         <div>
            <a href="/formWishlist" class="px-6 py-2 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-600 transition">
                <i class="fas fa-list-alt"></i> Form Wishlist
            </a>
        </div>

    </div>
</div>
