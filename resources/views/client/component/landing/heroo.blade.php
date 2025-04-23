<section data-aos="fade-up" data-aos-duration="1000" class="container mx-auto px-4 py-8 mt-24">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-gray-100 md:p-8 p-4 rounded-lg">
        <!-- Right Side (Image Slider) -->
        <div class="order-1 md:order-2 h-full">
            <div class="swiper-container h-full">
                <div class="swiper-wrapper">
                    @foreach ($perumahanStat as $p)
                        @if ($p->status === 'Available')
                            <div class="swiper-slide">
                                <!-- Image -->
                                @if ($p->images->isNotEmpty())
                                    <img class="w-full h-full" src="{{ asset('storage/' . $p->images->first()->image_path) }}" alt="House Image">
                                @else
                                    <img class="w-full h-full" src="https://source.unsplash.com/1417x745/?house" alt="Default House Image">
                                @endif

                                <!-- Location Text -->
                                <span class="text-lg font-semibold">{{ $p->perumahan }}</span>

                                <!-- Button -->
                                <a href="/showPerumahan/{{$p->id}}">See details</a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Left Side (Text) -->
        <div class="order-2 md:order-1 flex flex-col justify-center">
            <p class="text-gray-700 text-justify md:mr-10">
               <span class="font-bold">Ara Development Property,</span> memulai dari pemasaran property secondary dan kini telah banyak bekerjasama dengan property primary. Kami memiliki team yang bekerja memasarkan setiap produk yang kami kerjasamakan dan juga pembangunan property. Dan kini kami juga telah memiliki tambahan service lain diluar pemasaran. Jika anda pemilik property atau pencari property, kontak kami untuk mendapatkan pelayanan terbaik, karena kami punya fitur-fitur berbeda dengan yang lain.
            </p>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const swiper = new Swiper('.swiper-container', {
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
        });
    });
</script>
