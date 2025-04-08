@extends('admin.layouts.index', ['title' => 'Data User', 'page_heading' => 'Data User'])


@section('content')
@include('sweetalert::alert')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">
        {{-- <a href="{{ route('admin.createTeacher') }}" class="btn btn-success me-2 py-2" > --}}
        <a href="{{ route('admin.createUser') }}" class="btn btn-success me-2 py-2" >
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
                    <th class="col-md-2">Nama</th>
                    <th class="col-md-2">Email</th>
                    <th class="col-md-2">Role</th>
                    <th class="col-md-2">Action</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($user as $u)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->role }}</td>
                        <td>
                            <a href="{{ route('admin.editUser', ['id' => $u->id]) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            @if (auth()->user()->role !== 'salesAdmin')
                            <form onsubmit="return confirm('Apakah anda yakin ingin menghapus data?')" class="d-inline" action="{{ route('admin.deleteUser') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $u->id }}">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
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


