@extends('admin.layouts.index', ['title' => 'Tambah Data Report', 'page_heading' => 'Tambah Data Report'])

@section('content')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">

		<!-- Table untuk memanggil data dari database -->
        @include('sweetalert::alert')
		<form method="post" action="/reports/add/{{ $report->id }}" enctype="multipart/form-data">
        @csrf
            {{-- Title --}}
            <div class="mb-3 " hidden>
                <label for="pic" class="form-label">PIC</label>
                <input type="text" class="form-control" id="pic" name="pic" value="{{ $username }}" readonly>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Konsumen</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ $report->konsumen->nama_konsumen }}" readonly>
            </div>

            <div class="mb-3">
                <label for="perumahan" class="form-label">Perumahan</label>
                <input type="text" class="form-control" id="perumahan" name="perumahan" value="{{ $report->konsumen->perumahan }}" readonly>
            </div>

            <div class="mb-3">
                <label for="sumber_informasi" class="form-label">Sumber Informasi</label>
                <input type="text" class="form-control" id="sumber_informasi" name="sumber_informasi" value="{{ $report->konsumen->sumber_informasi }}" readonly>
            </div>

        {{-- <div class="mb-3 " hidden>
            <label for="PIC" class="form-label">PIC</label>
            <input type="text" class="form-control" id="PIC" name="PIC" value="{{ $username }}" readonly>
        </div> --}}

        <div class="mb-3">
            <label for="no_hp" class="form-label">Nomor Handphone</label>
            <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ $report->no_hp }}" readonly>
        </div>

        <div class="mb-3">
            <label for="pic" class="form-label">PIC</label>
            <input type="text" class="form-control" id="pic" name="pic" value="user" readonly>
        </div>

        <div class="mb-3">
            <label for="follow_up" class="form-label">Follow Up</label>
            <input type="text" class="form-control" id="follow_up" name="follow_up" value="{{ old('follow_up', $report->follow_up) }}" readonly>
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">
                Tanggal
                <span class="text-blue-500">
                    @foreach (explode("\n", $report->tanggal) as $tanggal)
                        ({{ \Carbon\Carbon::parse($tanggal)->format('Y/m/d') }})<br>
                    @endforeach
                </span>
            </label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" value="">
        </div>


        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="status" name="status">
                <option selected disabled>-- Pilih --</option>
                <option value="Sent">Sent</option>
                <option value="Respon">Respon</option>
                <option value="Prospek">Prospek</option>
                <option value="No Respon">No Respon</option>
                <option value="Pending">Pending</option>
                <option value="Closing">Closing</option>
                <option value="Drop" class="text-red-500">Drop</option>
            </select>
        </div>

        <div class="alasan mb-3 mt-20" style="display: none;">
            <label for="alasan" class="form-label">Alasan Drop</label>
            <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="alasan" name="alasan">
                <option selected disabled>-- Pilih --</option>
                <option value="Budget Tidak Sesuai">Budget Tidak Sesuai</option>
                <option  value="Lokasi Kurang Cocok">Lokasi Kurang Cocok</option>
                <option  value="Layout Belum Cocok">Layout Belum Cocok</option>
                <option  value="Akses Masuknya Tidak Cocok">Akses Masuknya Tidak Cocok</option>
                <option  value="Cari Perumahan Bukan Cluster Kecil">Cari Perumahan Bukan Cluster Kecil</option>
                <option value="Tidak Ada Fasilitas Dalam Perumahan">Tidak Ada Fasilitas Dalam Perumahan</option>
                <option  value="BI Checking Tidak Lewat">BI Checking Tidak Lewat</option>
                <option  value="KPR Ditolak Bank" class="text-red-500">KPR Ditolak Bank</option>
                <option  value="SP3K KPR Lolos DP Kurang" class="text-red-500">SP3K KPR Lolos DP Kurang</option>
                <option  value="Usahanya Tidak Bankable Cash Kurang" class="text-red-500">Usahanya Tidak Bankable Cash Kurang</option>
                <option  value="Batal Karena Alasan Musibah" class="text-red-500">Batal Karena Alasan Musibah</option>
                <option  value="No Kontak Tidak Bisa Dihubungi" class="text-red-500">No Kontak Tidak Bisa Dihubungi</option>
                <option  value="Sudah Dapat Rumah Lain" class="text-red-500">Sudah Dapat Rumah Lain</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="koresponden" class="form-label">Koresponden</label>
            <textarea class="form-control" id="koresponden" name="koresponden" style="width: 100%; height: 200px;"></textarea>
        </div>

            <button type="submit" class="btn btn-primary">Create</button>
            <a class="btn btn-danger" href="{{ route('admin.report') }}">Back</a>
        </form>

		{{-- Menampilkan total pemasukan --}}
		<div class="d-flex align-items-end flex-column p-2 mb-2">
			{{-- <p class="h4 p-3 rounded fw-bolder">Total Pemasukan : Rp. {{ $totalPemasukan }}</p> --}}
		</div>

  </div>
</div>

</section>

<script>
document.getElementById('konsumen_id').addEventListener('change', function() {
    var selectedOption = this.options[this.selectedIndex];
    var noHp = selectedOption.getAttribute('data-nohp');
    var perumahan = selectedOption.getAttribute('data-perumahan');
    var sumber = selectedOption.getAttribute('data-sumber');

    document.getElementById('no_hp').value = noHp;
    document.getElementById('perumahan').value = perumahan;
    document.getElementById('sumber_informasi').value = sumber;
});

document.addEventListener('DOMContentLoaded', function() {
    var statusSelect = document.getElementById('status');
    var keteranganDiv = document.querySelector('.alasan');

    statusSelect.addEventListener('change', function() {
        if (this.value === 'Drop') {
            keteranganDiv.style.display = 'block';
        } else {
            keteranganDiv.style.display = 'none';
        }
    });
});

</script>


@endsection



