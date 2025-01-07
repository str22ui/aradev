@extends('admin.layouts.index', ['title' => 'Data Secondary', 'page_heading' => 'Data Secondary'])


@section('content')
@include('sweetalert::alert')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">
        {{-- <a href="{{ route('admin.createTeacher') }}" class="btn btn-success me-2 py-2" > --}}
        <a href="{{ route('admin.createSecondary') }}" class="btn btn-success me-2 py-2" >
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
                    <th class="col-md-2">Image</th>
                    <th class="col-md-2">Perumahan</th>
                    <th class="col-md-2">Harga</th>
                    <th class="col-md-2 ">Kota</th>
                    <th class="col-md-2">Status</th>
                    <th class="col-md-3">Action</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($secondary as $s)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if ($s->imagesSecondary && $s->imagesSecondary->isNotEmpty())
                            {{-- Menampilkan gambar pertama --}}
                            <img class="rounded-t-lg"
                                 src="{{ asset('storage/' . $s->imagesSecondary->first()->image_path) }}"
                                 alt="" style="width: 100px;" />
                        @else
                            {{-- Fallback jika tidak ada gambar --}}
                            <img src="https://source.unsplash.com/1417x745/?house"
                                 class="d-block w-100 rounded-4"
                                 alt="..." style="width: 100px;">
                        @endif

                        </td>
                        <td>{{ $s->judul }}</td>
                        <td>{{ $s->harga }}</td>
                        <td>{{ $s->kota }}</td>
                        <td>{{ $s->status }}</td>
                        <td>
                            {{-- <a href='#' class="btn btn-primary btn-sm"><i class="bi bi-eye-fill"></i></a> --}}
                            <a href="{{ route('admin.editSecondary', ['id' => $s->id]) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form onsubmit="return confirm('Apakah anda yakin ingin menghapus data?')" class="d-inline" action="{{ route('admin.deleteSecondary') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $s->id }}">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
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


