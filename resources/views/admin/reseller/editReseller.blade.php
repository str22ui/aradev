@extends('admin.layouts.index', ['title' => 'Edit Data Reseller', 'page_heading' => 'Edit Data Reseller'])

@section('content')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">

		<!-- Table untuk memanggil data dari database -->
        @include('sweetalert::alert')
        <form method="post" action="{{ route('admin.updateReseller', ['id' => $reseller->id]) }}" enctype="multipart/form-data">
            @method('PUT')
        @csrf
            {{-- Title --}}


            <div class="mb-3">
              <input type="hidden" value="0" name="views">
              <label for="nama" class="form-label">Nama Agent</label>
              <input type="text" value="{{ $reseller->nama }}" name="nama" id="nama" placeholder="Masukkan Nama Agent" class="form-control">

            </div>

            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                <input type="text" value="{{ $reseller->pekerjaan }}" name="pekerjaan" id="pekerjaan" placeholder="Masukkan Pekerjaan" class="form-control">
            </div>


            <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="no_hp" class="form-label">No Telepon</label>
                <input type="number" value="{{ $reseller->no_hp }}" name="no_hp" id="no_hp" placeholder="Masukkan Nomor Telepon" class="form-control">
              </div>


              <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="kota" class="form-label">Kota</label>
                <input type="text" value="{{ $reseller->kota }}" name="kota" id="kota" placeholder="Masukkan Nomor Telepon" class="form-control">
              </div>

              <div class="mb-3">
                <input type="hidden" value="0" name="views">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" value="{{ $reseller->alamat }}" name="alamat" id="alamat" placeholder="Masukkan Alamat" class="form-control">
              </div>

            <br>
            <button type="submit" class="btn btn-primary">Update</button>
            <a class="btn btn-danger" href="{{ route('admin.Reseller') }}">Back</a>
        </form>

		{{-- Menampilkan total pemasukan --}}
		<div class="d-flex align-items-end flex-column p-2 mb-2">
			{{-- <p class="h4 p-3 rounded fw-bolder">Total Pemasukan : Rp. {{ $totalPemasukan }}</p> --}}
		</div>

  </div>
</div>

</section>

<script>
document.getElementById('tipe').addEventListener('change', function() {
            var kantorInput = document.getElementById('kantor');
            if (this.value === 'Perorangan') {
                kantorInput.value = 'N/A';
                kantorInput.readOnly = true;
            } else {
                kantorInput.value = '';
                kantorInput.readOnly = false;
            }
        });





</script>


@endsection



