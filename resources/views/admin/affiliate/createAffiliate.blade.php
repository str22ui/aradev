@extends('admin.layouts.index', ['title' => 'Tambah Data Affiliate', 'page_heading' => 'Tambah Data Affiliate'])

@section('content')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">

		<!-- Table untuk memanggil data dari database -->
        @include('sweetalert::alert')
		<form method="post" action="{{ route('admin.storeAffiliate') }}" enctype="multipart/form-data">
        @csrf
            {{-- Title --}}

            <div class="mb-3">
            <label for="referral_code">Kode Referral (Agent / Reseller)</label>
            <input type="text" name="referral_code" id="referral_code" placeholder="Masukkan kode referral dari Agent/Reseller" class="form-control">

            </div>


            <div class="mb-3">
              <label for="name" class="form-label">Nama Affiliate</label>
              <input type="text" autofocus value="" name="name" id="name" placeholder="Masukkan Nama Affiliate" class="form-control">
            </div>


            <div class="mb-3">
              <label for="phone" class="form-label">No Handphone</label>
              <input type="text" value="" name="phone" id="phone" placeholder="Masukkan Nomor hp" class="form-control">
            </div>

            <div class="mb-3">
              <label for="address" class="form-label">Alamat</label>
              <input type="text" value="" name="address" id="address" placeholder="Masukkan Alamat" class="form-control">
            </div>

            <div class="mb-3">
              <label for="commision_rate" class="form-label">Komisi </label>
              <input type="text" value="" name="commission_rate" id="commission_rate" placeholder="Masukkan Komisi" class="form-control">
            </div>

            <div class="mb-3">
              <label for="total_sales" class="form-label">Total Sales</label>
              <input type="text" value="" name="total_sales" id="total_sales" placeholder="Masukkan Total Sales" class="form-control">
            </div>

            <div class="mb-3">
              <label for="total_commission" class="form-label">Total Komisi</label>
              <input type="text" value="" name="total_commission" id="total_commission" placeholder="Masukkan Total Komisi" class="form-control">
            </div>

            <div class="mb-3">
              <label for="joined_at" class="form-label">Tanggal Join</label>
              <input type="date" name="joined_at" id="joined_at" class="form-control">
            </div>
            <div id="perumahan-container">
                <label for="perumahan_id" class="form-label block mb-2 text-sm font-medium">Perumahan</label>
                <select id="perumahan_id" name="perumahan_id[]"
                    class="form-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="pilih">-- Pilih --</option>
                    @foreach ($perumahan as $item)
                        <option value="{{ $item->id }}">{{ $item->perumahan }}</option>
                    @endforeach
                </select>
            </div>
            <button type="button" onclick="addPerumahan()" class="btn btn-secondary my-3">Tambah Perumahan</button><br>
        <div class="mb-3">
            <label for="email" class="form-label">Email Affiliate</label>
            <input type="email" name="email" id="email" placeholder="Masukkan Email Affiliate" class="form-control" required>
        </div>

        <!-- Tambahkan password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password Login</label>
            <input type="password" name="password" id="password" placeholder="Masukkan Password" class="form-control" required>
        </div>

        <!-- Role bisa hidden karena otomatis agent -->
        <input type="hidden" name="role" value="affiliate">


            <button type="submit" class="btn btn-primary">Create</button>
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

</script>


@endsection



