<div class="mx-auto mt-24 py-6">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-gray-800 text-center mb-8">Wishlist Aradev</h2>
        <div class="text-md b">
            <p class="mb-3">Wishlist Ara Development Property - Solusi praktis bagi Anda yang ingin menemukan atau menawarkan properti dengan lebih mudah. Wishlist kami akan membantu anda:</p>
            <ul class="list-disc list-inside ml-12">
                <li>Untuk Pencari Properti, baik untuk dibeli maupun disewa, mulai dari hunian nyaman hingga properti komersial yang strategis.</li>
                <li>Untuk Pemilik Properti & Tanah, maksimalkan potensi properti Anda dengan menjangkau calon pembeli atau penyewa yang serius.</li>
            </ul>
            <p class="my-5">Bersama kami, proses jual-beli dan sewa-menyewa properti menjadi lebih efektif, cepat, dan menguntungkan. Wujudkan tujuan properti Anda sekarang, sampaikan keinginan dengan mengisi form wishlist kami:</p>
        </div>

        <div class="flex justify-center gap-6 my-8">
            <a href="/formWishlist" class="px-6 py-2 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-600 transition">
                Form Wishlist
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($wishlist as $w)
            <div class="bg-white shadow-lg rounded-xl overflow-hidden transform hover:scale-105 transition duration-300 border-t-4
                @if($w->status == 'Available') border-green-500
                @elseif($w->status == 'Closed') border-red-500
                @elseif($w->status == 'Remove') border-gray-500
                @endif">

                <!-- Konten Card -->
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-bold text-gray-900">{{ $w->nama }}</h3>
                        <span class="px-3 py-1 text-white font-semibold text-sm rounded
                            @if($w->status == 'Available') bg-green-500
                            @elseif($w->status == 'Closed') bg-red-500
                            @elseif($w->status == 'Remove') bg-gray-500
                            @endif">
                            {{ $w->status }}
                        </span>
                    </div>

                    <p class="text-gray-700 mt-2"><strong>Permintaan:</strong> {{ $w->permintaan }} {{ $w->jenis }}</p>
                    <p class="text-gray-600 text-sm mt-1">Lokasi: {{ $w->lokasi }}</p>
                    <p class="text-green-600 font-semibold mt-2 text-lg">Harga: Rp {{ $w->harga_budget }}</p>
                    <p class="text-gray-600 mt-4 text-sm leading-relaxed">{!! $w->keterangan !!}</p>
                </div>
            </div>
            @endforeach
        </div>


    </div>
</div>
