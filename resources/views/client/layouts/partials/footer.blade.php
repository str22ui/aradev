<footer >
    <div class="bg-primary text-white py-6 px-5 mt-8">
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 text-center md:text-left">
            <div>
                <h3 class="font-bold mb-2">Ara Development Property</h3>
                <p class="text-sm">Ara Development Property, kami ada bersama anda, melewati berbagai tantangan, belajar, dan berkembang untuk menjadi lebih baik. Hari ini, dengan penuh semangat, kami memperkenalkan identitas baru kami – sebuah langkah maju untuk melayani Anda dengan lebih baik!</p>
            </div>

            <div>
                <h3 class="font-bold mb-2">Project</h3>
                <ul class="text-sm list-none">
                @foreach ($allPerumahan as $p)
                    <li>{{ $p->perumahan }}</li>
                @endforeach
                </ul>
            </div>

            <div>
                <h3 class="font-bold mb-2">Location</h3>
                <p class="text-sm">Sawangan Village Cluster Swarna Asri A-08 Jl. Raya Mokhtar, Kelurahan Bedahan Kecamatan Sawangan Kota Depok 16511</p>
                {{-- <p class="mt-2"><i class="fas fa-phone-alt"></i> 021 - 77972409 (office)</p> --}}
            </div>
        </div>
    </div>

</footer>



@vite('resources/js/app.js')
</html>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<script>
    // var swiper = new Swiper('.swiper-container', {
    //     slidesPerView: 1,   // Menampilkan satu card per view
    //     spaceBetween: 10,   // Jarak antara card
    //     loop: true,         // Membuat slider loop
    //     pagination: {
    //         el: '.swiper-pagination',
    //         clickable: true,
    //     },
    //     navigation: {
    //         nextEl: '.swiper-button-next',
    //         prevEl: '.swiper-button-prev',
    //     },
    //     breakpoints: {
    //         640: {
    //             slidesPerView: 1,
    //             spaceBetween: 10,
    //         },
    //         768: {
    //             slidesPerView: 2,
    //             spaceBetween: 20,
    //         },
    //         1024: {
    //             slidesPerView: 3,
    //             spaceBetween: 30,
    //         },
    //     },
    // });
//     function filterStatus() {
//     const status = document.getElementById('filter-status').value;
//     window.location.href = `?status=${status}`;
// }
    // Dapatkan parameter 'status' dari URL
    const urlParams = new URLSearchParams(window.location.search);
    const activeStatus = urlParams.get('status') || 'all'; // Default 'all' jika tidak ada parameter

    // Tandai tombol aktif berdasarkan status
    document.querySelectorAll('.filter-btn').forEach(button => {
        const status = button.getAttribute('data-status');
        if (status === activeStatus) {
            button.classList.add('bg-primary', 'text-white');
        } else {
            button.classList.remove('bg-primary', 'text-white');
        }

        // Event listener untuk mengubah status filter
        button.addEventListener('click', () => {
            window.location.href = `?status=${status}`;
        });
    });



    var cardSwiper = new Swiper('.card-slider-container', {
    loop: true, // Membuat slider berulang
    autoplay: {
        delay: 3000, // Interval pergantian slide otomatis (3000ms = 3 detik)
        disableOnInteraction: false, // Autoplay tetap berlanjut setelah interaksi pengguna
    },
    pagination: {
        el: '.swiper-pagination', // Menentukan elemen pagination
        clickable: true, // Pagination dapat diklik untuk navigasi
    },
    effect: 'fade', // Efek transisi fade antar slide
    fadeEffect: {
        crossFade: true, // Memungkinkan transisi antar slide terlihat halus
    },
    });
    var cardSwiper2 = new Swiper('.card-slider-container', {
        loop: true, // Make the slider loop
        autoplay: {
            delay: 3000, // Auto slide interval in ms
            disableOnInteraction: false, // Continue autoplay even after user interaction
        },
        pagination: {
            el: '.swiper-pagination', // Pagination element
            clickable: true,           // Make pagination clickable
        },
        effect: 'fade', // Fade effect for transitions
        fadeEffect: {
            crossFade: true,  // Crossfade for smooth transitions
        },
    });
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('success-modal');
        const closeModal = document.getElementById('close-modal');

        if (modal && closeModal) {
            closeModal.addEventListener('click', () => {
                modal.style.display = 'none';
            });
        }
    });

//     var infoInput = document.getElementById('info-input');

//     // Mendapatkan elemen div dengan class 'agent'
//     var agentDiv = document.querySelector('.agent');

//     // Menyembunyikan div dengan class 'agent' secara default
//     agentDiv.style.display = 'none';

//     // Menambahkan event listener untuk mendeteksi perubahan pada elemen radio
//     infoInput.addEventListener('change', function() {
//         // Mencari elemen radio yang dipilih
//         var selectedRadio = document.querySelector('input[name="sumber_informasi"]:checked');

//         // Jika opsi yang dipilih adalah 'Agent', maka tampilkan div dengan class 'agent', jika tidak, sembunyikan
//         if (selectedRadio && selectedRadio.value === 'Agent') {
//             agentDiv.style.display = 'flex'; // Menampilkan div dengan class 'agent'
//         } else {
//             agentDiv.style.display = 'none'; // Menyembunyikan div dengan class 'agent'
//         }
//     });

//    // Mendapatkan elemen dropdown 'sumber_informasi'
//     var sumberInformasiDropdown = document.getElementById('sumber_informasi');

//     // Mendapatkan elemen div dengan class 'agent'
//     var agentDiv = document.querySelector('.agent');

//     // Menyembunyikan div dengan class 'agent' secara default
//     agentDiv.style.display = 'none';

//     // Menambahkan event listener untuk mendeteksi perubahan pada dropdown
//     sumberInformasiDropdown.addEventListener('change', function() {
//         // Jika opsi yang dipilih adalah 'Agent', tampilkan div dengan class 'agent'
//         if (sumberInformasiDropdown.value === 'Agent') {
//             agentDiv.classList.remove('hidden'); // Menampilkan elemen
//         } else {
//             agentDiv.classList.add('hidden'); // Menyembunyikan elemen
//         }

//     });

        // Mendapatkan elemen
    var radioInputs = document.querySelectorAll('input[name="info_radio"]');
    var dropdownInput = document.getElementById('sumber_informasi');
    var agentDiv = document.querySelector('.agent');

    // Menyembunyikan form agent secara default
    agentDiv.style.display = 'none';

    // Event listener untuk radio button
    radioInputs.forEach(function(radio) {
        radio.addEventListener('change', function() {
            if (radio.value === 'Agent') {
                agentDiv.style.display = 'flex'; // Tampilkan form agent
            } else {
                agentDiv.style.display = 'none'; // Sembunyikan form agent
            }
        });
    });

    // Event listener untuk dropdown
    dropdownInput.addEventListener('change', function() {
        if (dropdownInput.value === 'Agent') {
            agentDiv.style.display = 'flex'; // Tampilkan form agent
        } else {
            agentDiv.style.display = 'none'; // Sembunyikan form agent
        }
    });


    document.getElementById('rumah_id').addEventListener('change', function() {
    var selectedOption = this.options[this.selectedIndex];
    var lt = selectedOption.getAttribute('data-lt');
    var lb = selectedOption.getAttribute('data-lb');
    var posisi = selectedOption.getAttribute('data-posisi');
    var harga = selectedOption.getAttribute('data-harga');


    document.getElementById('luas_tanah').value = lt;
    document.getElementById('luas_bangunan').value = lb;
    document.getElementById('posisi').value = posisi;
    document.getElementById('harga').value = harga;
});

    document.querySelectorAll('.filter-btn').forEach(button => {
        button.addEventListener('click', () => {
            const status = button.getAttribute('data-status'); // Ambil status dari tombol
            const slides = document.querySelectorAll('.swiper-slide'); // Semua slide

            slides.forEach(slide => {
                if (slide.getAttribute('data-status') === status || status === 'All') {
                    slide.style.display = ''; // Tampilkan slide
                } else {
                    slide.style.display = 'none'; // Sembunyikan slide
                }
            });

            // Update Swiper agar tampilan ter-refresh
            swiper.update();
        });
    });


</script>
