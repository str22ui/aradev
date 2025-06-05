<div class="bg-white rounded-xl p-6 shadow-lg mt-10 max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-2">Simulasi Cicilan KPR</h2>
    <p class="text-sm text-gray-600 mb-6">Hitung estimasi cicilan berdasarkan harga rumah yang dipilih</p>

    <form id="kprForm" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Harga Properti</label>
            <input type="text"
                value="{{ number_format($perumahan->harga_asli, 0, ',', '.') }}"
                id="hargaProperti"
                class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2"
                oninput="formatHargaInput(this)" />
            <input type="hidden" id="hargaAsli" value="{{ $perumahan->harga_asli }}">

        </div>

        <div class="grid grid-cols-3 gap-4">
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700">Down Payment (DP)</label>
                <input type="text" id="dp" placeholder="Rp"
                       class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2"
                       oninput="formatDpInput(this)" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Persen (%)</label>
                <input type="number" id="dpPersen" placeholder="%" value="15"
                       class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2" />
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Jumlah Kredit</label>
            <input type="text" readonly id="jumlahKredit"
                   class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100 text-gray-700" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Jangka Waktu (tahun)</label>
                <input type="number" id="jangkaWaktu" value="30"
                       class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Bunga (%)</label>
                <input type="number" id="bunga" value="5"
                       class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2" />
            </div>
        </div>

        <button type="button" onclick="hitungKPR()"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded mt-4 transition">
            Hitung Cicilan
        </button>
    </form>

    <div id="hasilKpr" class="mt-6 hidden">
        <h3 class="text-lg font-semibold mb-3 text-gray-800">Angsuran KPR per Bulan</h3>
        <ul class="space-y-2 text-sm text-gray-700" id="angsuranList"></ul>
    </div>
</div>
<script>

    const hargaProperti = {{ $perumahan->harga_asli }};

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka);
    }

    function formatDpInput(input) {
        let value = input.value.replace(/[^\d]/g, '');
        input.value = new Intl.NumberFormat('id-ID').format(value);
    }

    function parseRupiah(rp) {
        return parseInt(rp.replace(/[^\d]/g, '')) || 0;
    }

   function hitungKPR() {
    const hargaInput = parseRupiah(document.getElementById('hargaProperti').value);
    const hargaAwal = parseInt(document.getElementById('hargaAsli').value); // untuk perbandingan kalau perlu
    const dpInput = parseRupiah(document.getElementById('dp').value);
    const persenInput = parseFloat(document.getElementById('dpPersen').value) || 0;

    // Hitung DP
    const dpFromPercent = hargaInput * (persenInput / 100);
    const dpFinal = dpInput > 0 ? dpInput : dpFromPercent;

    const jumlahKredit = hargaInput - dpFinal;
    const bunga = parseFloat(document.getElementById('bunga').value) || 0;
    const jangkaWaktu = parseInt(document.getElementById('jangkaWaktu').value) || 0;

    // Update nilai hasil
    document.getElementById('dp').value = new Intl.NumberFormat('id-ID').format(dpFinal);
    document.getElementById('jumlahKredit').value = formatRupiah(jumlahKredit);

    // Hitung cicilan
    const tahunOptions = [5, 10, 15, 20, 25, 30];
    const list = document.getElementById('angsuranList');
    list.innerHTML = '';

    tahunOptions.forEach(tahun => {
        const n = tahun * 12;
        const i = bunga / 12 / 100;
        const angsuran = jumlahKredit * i / (1 - Math.pow(1 + i, -n));
        const li = document.createElement('li');
        li.innerHTML = `<span class="font-medium">${tahun} tahun:</span> <span class="text-blue-600 font-semibold">${formatRupiah(angsuran)}</span> / bulan`;
        list.appendChild(li);
    });

    document.getElementById('hasilKpr').classList.remove('hidden');
}


    function formatHargaInput(input) {
    let value = input.value.replace(/[^\d]/g, '');
    input.value = new Intl.NumberFormat('id-ID').format(value);
}

</script>
