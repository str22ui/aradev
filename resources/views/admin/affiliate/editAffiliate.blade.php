@extends('admin.layouts.index', ['title' => 'Edit Data Agent', 'page_heading' => 'Edit Data Affiliates'])

@section('content')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">

		<!-- Table untuk memanggil data dari database -->
        @include('sweetalert::alert')
        <form method="post" action="{{ route('admin.updateAffiliate', ['id' => $affiliate->id]) }}" enctype="multipart/form-data">
            @method('PUT')
        @csrf
            {{-- Title --}}


            <div class="mb-3">
              <label for="name" class="form-label">Nama Affiliate</label>
              <input type="text" value="{{ $affiliate->name }}" name="name" id="name"  class="form-control">
            </div>

            <div class="mb-3">
              <label for="phone" class="form-label">No Handphone</label>
              <input type="text" value="{{ $affiliate->phone }}" name="phone" id="phone"  class="form-control">
            </div>

             <div class="mb-3">
              <label for="address" class="form-label">Alamat</label>
              <input type="text" value="{{ $affiliate->address }}" name="address" id="address"  class="form-control">
            </div>

             <div class="mb-3">
              <label for="joined_at" class="form-label">Tanggal Join</label>
              <input type="text" value="{{ $affiliate->joined_at }}" name="joined_at" id="joined_at"  class="form-control">
            </div>

            <!-- TAMBAHKAN BAGIAN INI -->
            <div class="mb-3 border p-3 rounded bg-light">
                <label for="referrer_code" class="form-label fw-bold">
                    <i class="bi bi-person-check"></i> Kode Referral Sales
                </label>

                <!-- Tampilkan referrer saat ini (jika ada) -->
                @if($affiliate->referrer)
                    <div class="alert alert-info mb-2">
                        <strong>Referrer Saat Ini:</strong> {{ $affiliate->referrer->name }}
                        <code>({{ $affiliate->referrer->code }})</code>
                    </div>
                @else
                    <div class="alert alert-warning mb-2">
                        <i class="bi bi-exclamation-triangle"></i> Affiliate ini belum terhubung dengan Sales
                    </div>
                @endif

                <!-- Input kode referral baru -->
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-upc-scan"></i>
                    </span>
                    <input type="text"
                        name="referrer_code"
                        id="referrer_code"
                        class="form-control"
                        placeholder="Masukkan kode referral Sales (kosongkan untuk hapus referrer)"
                        value="{{ $affiliate->referrer ? $affiliate->referrer->code : old('referrer_code') }}">
                    <button type="button" class="btn btn-outline-secondary" onclick="checkReferralCode()">
                        <i class="bi bi-search"></i> Cek Kode
                    </button>
                </div>

                <small class="text-muted d-block mt-1">
                    💡 Masukkan kode untuk menghubungkan/mengubah referrer. Kosongkan untuk menghapus referrer.
                </small>

                <div id="referrer-info" class="mt-2"></div>

                <!-- Dropdown manual pilih Sales (alternatif) -->
                <div class="mt-3">
                    <label for="sales_selector" class="form-label">Atau Pilih Sales Langsung</label>
                    <select id="sales_selector" class="form-select" onchange="fillReferralCode(this)">
                        <option value="">-- Pilih Sales --</option>
                        @foreach($salesUsers as $sales)
                            <option value="{{ $sales->code }}"
                                    data-name="{{ $sales->name }}"
                                    {{ $affiliate->referrer && $affiliate->referrer->id == $sales->id ? 'selected' : '' }}>
                                {{ $sales->name }} ({{ $sales->code ?? $sales->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- <div id="perumahan-container">
                <label for="perumahan_id" class="form-label block mb-2 text-sm font-medium">Perumahan yang Dipilih</label>
                @foreach ($affiliate->perumahan_id as $index => $selectedId)
                    <div class="flex items-center space-x-2">
                        <select name="perumahan_id[]"
                            class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mt-2">
                            <option value="pilih">-- Pilih --</option>
                            @foreach ($perumahan as $item)
                                <option value="{{ $item->id }}" {{ $item->id == $selectedId ? 'selected' : '' }}>
                                    {{ $item->perumahan }}
                                </option>
                            @endforeach
                        </select>
                        <button type="button" class="btn-delete btn-danger text-white text-sm px-3 py-1 mt-1 rounded"
                        onclick="removePerumahan(this, {{ $index }})">Hapus</button>
                    </div>
                    @endforeach
                </div> --}}
                {{-- <button type="button" onclick="addPerumahan()" class="btn btn-secondary my-3">Tambah Perumahan</button> --}}
            <!-- Password Baru (Opsional) -->
        <div class="mb-3">
        <label for="password" class="form-label">Password Baru (Opsional)</label>
        <input type="password"
                name="password"
                id="password"
                class="form-control"
                placeholder="Kosongkan jika tidak ingin mengubah password">
        <small class="text-muted">Minimal 6 karakter. Kosongkan jika tidak ingin mengubah.</small>
        </div>

        <!-- Konfirmasi Password -->
        <div class="mb-3">
        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
        <input type="password"
                name="password_confirmation"
                id="password_confirmation"
                class="form-control"
                placeholder="Ulangi password baru">
        </div>


            <br>
            <button type="submit" class="btn btn-primary">Update</button>
            <a class="btn btn-danger" href="{{ route('admin.affiliate') }}">Back</a>
        </form>

		{{-- Menampilkan total pemasukan --}}
		<div class="d-flex align-items-end flex-column p-2 mb-2">
			{{-- <p class="h4 p-3 rounded fw-bolder">Total Pemasukan : Rp. {{ $totalPemasukan }}</p> --}}
		</div>

  </div>
</div>

</section>
<script>
// Function untuk mengisi kode referral dari dropdown
function fillReferralCode(select) {
    const code = select.value;
    const name = select.options[select.selectedIndex].dataset.name;

    if (code) {
        document.getElementById('referrer_code').value = code;
        document.getElementById('referrer-info').innerHTML =
            `<div class="alert alert-success">
                <i class="bi bi-check-circle"></i> Sales dipilih: <strong>${name}</strong> (${code})
            </div>`;
    } else {
        document.getElementById('referrer_code').value = '';
        document.getElementById('referrer-info').innerHTML = '';
    }
}

// Function untuk cek kode referral
function checkReferralCode() {
    const code = document.getElementById('referrer_code').value.trim().toUpperCase();

    if (!code) {
        document.getElementById('referrer-info').innerHTML =
            `<div class="alert alert-warning">
                <i class="bi bi-info-circle"></i> Kode dikosongkan. Referrer akan dihapus saat update.
            </div>`;
        return;
    }

    // Set uppercase
    document.getElementById('referrer_code').value = code;

    // Cek apakah kode ada di dropdown
    const salesSelect = document.getElementById('sales_selector');
    const option = Array.from(salesSelect.options).find(opt => opt.value === code);

    if (option) {
        const name = option.dataset.name;
        document.getElementById('referrer-info').innerHTML =
            `<div class="alert alert-success">
                <i class="bi bi-check-circle"></i> Kode valid! Sales: <strong>${name}</strong>
            </div>`;
        salesSelect.value = code;
    } else {
        document.getElementById('referrer-info').innerHTML =
            `<div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle"></i> Kode tidak ditemukan atau bukan milik Sales
            </div>`;
    }
}

// Auto uppercase saat mengetik
document.getElementById('referrer_code').addEventListener('input', function(e) {
    this.value = this.value.toUpperCase();
});
</script>

{{-- <script>
      function addPerumahan() {
        const container = document.getElementById('perumahan-container');

        // Buat elemen <select> baru
        const newSelect = document.createElement('select');
        newSelect.name = 'perumahan_id[]';
        newSelect.classList.add(
            'form-select',
            'bg-gray-50',
            'border',
            'border-gray-300',
            'text-gray-900',
            'text-sm',
            'rounded-lg',
            'focus:ring-blue-500',
            'focus:border-blue-500',
            'block',
            'w-full',
            'p-2.5',
            'mt-2'
        );

        // Tambahkan opsi dari array PHP
        const perumahanData = @json($perumahan); // Mengambil data dari server
        const defaultOption = document.createElement('option');
        defaultOption.value = 'pilih';
        defaultOption.textContent = '-- Pilih --';
        newSelect.appendChild(defaultOption);

        // Loop melalui data PHP dan tambahkan opsi ke <select>
        perumahanData.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = `${item.perumahan}`;
            newSelect.appendChild(option);
        });

        // Tambahkan elemen <select> ke dalam container
        container.appendChild(newSelect);
    }

    function removePerumahan(button, index) {
    const container = document.getElementById('perumahan-container');
    const parentDiv = button.parentElement;
    container.removeChild(parentDiv);

    // Tandai data untuk dihapus di server (opsional, tergantung implementasi backend)
    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'delete_perumahan[]';
    hiddenInput.value = index;
    container.appendChild(hiddenInput);
}
</script> --}}

@endsection



