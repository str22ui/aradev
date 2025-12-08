@extends('admin.layouts.index', ['title' => 'Tambah Data Affiliate', 'page_heading' => 'Tambah Data Affiliate'])

@section('content')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">

		<!-- Table untuk memanggil data dari database -->
        @include('sweetalert::alert')

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

		<form method="post" action="{{ route('admin.storeAffiliate') }}" enctype="multipart/form-data">
        @csrf

            <div class="mb-3">
              <label for="name" class="form-label">Nama Affiliate</label>
              <input type="text" autofocus value="{{ old('name') }}" name="name" id="name"
                     placeholder="Masukkan Nama Affiliate" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="phone" class="form-label">No Handphone</label>
              <input type="text" value="{{ old('phone') }}" name="phone" id="phone"
                     placeholder="Masukkan Nomor hp" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="address" class="form-label">Alamat</label>
              <input type="text" value="{{ old('address') }}" name="address" id="address"
                     placeholder="Masukkan Alamat" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="joined_at" class="form-label">Tanggal Join</label>
              <input type="date" name="joined_at" id="joined_at"
                     value="{{ old('joined_at', date('Y-m-d')) }}" class="form-control">
            </div>

            <!-- SECTION REFERRAL CODE -->
            <div class="mb-3 border p-3 rounded bg-light">
                <label for="referrer_code" class="form-label fw-bold">
                    <i class="bi bi-person-check"></i> Kode Referral Sales (Opsional)
                </label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-upc-scan"></i>
                    </span>
                    <input type="text"
                           name="referrer_code"
                           id="referrer_code"
                           class="form-control"
                           placeholder="Masukkan kode referral dari Sales"
                           value="{{ old('referrer_code') }}">
                    <button type="button" class="btn btn-outline-secondary" onclick="checkReferralCode()">
                        <i class="bi bi-search"></i> Cek Kode
                    </button>
                </div>
                <small class="text-muted d-block mt-1">
                    Masukkan kode referral Sales untuk menghubungkan affiliate ini dengan Sales yang mereferensikan
                </small>
                <div id="referrer-info" class="mt-2"></div>
            </div>

            <!-- Dropdown manual pilih Sales (alternatif) -->
            <div class="mb-3">
                <label for="sales_selector" class="form-label">Atau Pilih Sales Langsung</label>
                <select id="sales_selector" class="form-select" onchange="fillReferralCode(this)">
                    <option value="">-- Pilih Sales --</option>
                    @foreach($salesUsers as $sales)
                        <option value="{{ $sales->code }}" data-name="{{ $sales->name }}">
                            {{ $sales->name }} ({{ $sales->code ?? $sales->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- <!-- Perumahan Selection -->
            <div class="mb-3">
                <label for="perumahan_id" class="form-label">Perumahan</label>
                <select multiple name="perumahan_id[]" id="perumahan_id" class="form-select" size="5">
                    @foreach($perumahan as $item)
                        <option value="{{ $item->id }}"
                                {{ in_array($item->id, old('perumahan_id', [])) ? 'selected' : '' }}>
                            {{ $item->perumahan }}
                        </option>
                    @endforeach
                </select>
                <small class="text-muted">Tekan Ctrl (Windows) atau Cmd (Mac) untuk memilih lebih dari satu</small>
            </div> --}}

            <!-- Login Credentials -->
            <div class="mb-3">
                <label for="email" class="form-label">Email Affiliate</label>
                <input type="email" name="email" id="email"
                       placeholder="Masukkan Email Affiliate"
                       class="form-control"
                       value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password Login</label>
                <input type="password" name="password" id="password"
                       placeholder="Masukkan Password" class="form-control" required>
            </div>

            <input type="hidden" name="role" value="affiliate">

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Create Affiliate
            </button>
            <a class="btn btn-danger" href="{{ route('admin.affiliate') }}">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </form>

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

// Function untuk cek kode referral (opsional - bisa pakai AJAX)
function checkReferralCode() {
    const code = document.getElementById('referrer_code').value;

    if (!code) {
        alert('Masukkan kode referral terlebih dahulu');
        return;
    }

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
            `<div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle"></i> Kode tidak ditemukan atau bukan milik Sales
            </div>`;
    }
}
</script>

@endsection
