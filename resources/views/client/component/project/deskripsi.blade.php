<div class="container mx-auto bg-white flex flex-col lg:flex-row justify-center items-start gap-8 mt-4 p-6 rounded-lg">
    @if(isset($embedUrl))
        <!-- Video -->
        <iframe
            src="{{ $embedUrl }}"
            frameborder="0"
            allowfullscreen
            class="rounded-lg shadow-lg w-full lg:w-1/2 lg:h-96 h-64">
        </iframe>
    @endif

    <!-- Deskripsi -->
    <div class="text-black flex-1 flex flex-col justify-between @if(!isset($embedUrl)) w-full @endif mt-4 lg:mt-0">
        <div>
            <h1 class="text-xl font-semibold mb-4">Deskripsi</h1>
            {{-- <p>{{ $perumahan->deskripsi }}</p> --}}
            <p>

                {{ Str::limit(str_replace('&nbsp;', ' ', strip_tags($perumahan->deskripsi)), 150) }}
            </p>
            <div class="prose">
                {!! $perumahan->deskripsi !!}
            </div>

        </div>

        <div class="mt-4 flex gap-4">
            @if ($perumahan->status === 'Available')
                <a href="/form/{{ $perumahan->id }}" class="btn-download flex items-center gap-2 text-blue-500">
                    <i class="fas fa-file-download"></i> Download Pricelist
                </a>
                <a href="/formPenawaran/{{ $perumahan->id }}" class="btn-penawaran flex items-center gap-2 ">
                    <i class="fas fa-handshake"></i> Penawaran
                </a>
            @else
                <button disabled class="btn-disabled flex items-center gap-2 text-gray-400 cursor-not-allowed">
                    <i class="fas fa-file-download"></i> Download Pricelist
                </button>
                <button disabled class="btn-disabled flex items-center gap-2 text-gray-400 cursor-not-allowed">
                    <i class="fas fa-handshake"></i> Penawaran
                </button>
            @endif
        </div>
    </div>
</div>
