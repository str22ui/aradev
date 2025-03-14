@extends('admin.layouts.index', ['title' => 'Data Wishlist', 'page_heading' => 'Data Wishlist'])


@section('content')
@include('sweetalert::alert')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">


        {{-- <a href="{{ route('admin.createTeacher') }}" class="btn btn-success me-2 py-2" > --}}
        <a href="{{ route('admin.createWishlist') }}" class="btn btn-success me-2 py-2" >
            + Insert Data
        </a>
        @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
        {{ session('success') }}
        </div>
        @endif
		<!-- Table untuk memanggil data dari database -->
		<table class="table">
            <thead>
                <tr>
                    <th class="col-sm-1">No</th>
                    <th class="col-md-2">Nama </th>
                    <th class="col-md-2">Domisili</th>
                    <th class="col-md-2 ">Permintaan</th>
                    <th class="col-md-2">Jenis</th>
                    <th class="col-md-2">Lokasi</th>
                    <th class="col-md-2">Budget</th>
                    <th class="col-md-2">Tanggal</th>
                    <th class="col-md-2">Action</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($wishlist as $w)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $w->nama }}</td>
                        <td>{{ $w->domisili }}</td>
                        <td>{{ $w->permintaan}}</td>
                        <td>{{ $w->jenis }}</td>
                        <td>{{ $w->lokasi }}</td>
                        <td>{{ $w->harga_budget }}</td>

                        <td>{{ $w->created_at->format('d/m/y') }}</td>
                        <td>
                            <a href="{{ route('admin.editWishlist', ['id' => $w->id]) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            @if (auth()->user()->role !== 'salesAdmin')
                            <form onsubmit="return confirm('Apakah anda yakin ingin menghapus data?')" class="d-inline" action="{{ route('admin.deleteWishlist') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <!-- Input untuk mengirim ID perumahan yang ingin dihapus -->
                                <input type="hidden" name="id" value="{{ $w->id }}">
                                <button type="submit" name="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></button>
                            </form>
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
		</table>


		<div class="d-flex align-items-end flex-column p-2 mb-2">

		</div>

		{{-- {{ $management->withQueryString()->links() }} --}}
  </div>
</div>

</section>
@endsection


