@extends('admin.layouts.index', ['title' => 'Data Reseller', 'page_heading' => 'Data Reseller'])


@section('content')
@include('sweetalert::alert')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">


        {{-- <a href="{{ route('admin.createTeacher') }}" class="btn btn-success me-2 py-2" > --}}
        <a href="{{ route('admin.createReseller') }}" class="btn btn-success me-2 py-2" >
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
                    <th class="col-md-2">No HP</th>
                    <th class="col-md-2">Pekerjaan</th>
                    <th class="col-md-2">Kota</th>
                    <th class="col-md-2">Alamat</th>
                    <th class="col-md-3">Action</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($reseller as $r)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $r->nama }}</td>
                        <td>{{ $r->no_hp }}</td>
                        <td>{{ $r->pekerjaan }}</td>
                        <td>{{ $r->kota }}</td>
                        <td>{{ $r->alamat }}</td>
                        <td>
                            <a href="{{ route('admin.editReseller', ['id' => $r->id]) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <form onsubmit="return confirm('Apakah anda yakin ingin menghapus data?')" class="d-inline" action="{{ route('admin.deleteReseller') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <!-- Input untuk mengirim ID perumahan yang ingin dihapus -->
                                <input type="hidden" name="id" value="{{ $r->id }}">
                                <button type="submit" name="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></button>
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


