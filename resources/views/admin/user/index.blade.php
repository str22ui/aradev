@extends('admin.layouts.index', ['title' => 'Data User', 'page_heading' => 'Data User'])

@section('content')
@include('sweetalert::alert')
<section class="row">
	<div class="col card px-3 py-3">

	<div class="my-3 p-3 rounded">
        <a href="{{ route('admin.createUser') }}" class="btn btn-success me-2 py-2">
            <i class="bi bi-plus-circle"></i> Insert Data
        </a>

        @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

		<!-- Table untuk memanggil data dari database -->
		<div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th class="col-sm-1">No</th>
                        <th class="col-md-2">Nama</th>
                        <th class="col-md-2">Email</th>
                        <th class="col-md-1">Role</th>
                        <th class="col-md-2">Perumahan</th>
                        <th class="col-md-2">Kode/Affiliate</th>
                        <th class="col-md-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user as $u)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>
                                @if($u->role == 'admin')
                                    <span class="badge bg-danger">Admin</span>
                                @elseif($u->role == 'salesAdmin')
                                    <span class="badge bg-warning text-dark">Sales Admin</span>
                                @elseif($u->role == 'sales')
                                    <span class="badge bg-info">Sales</span>
                                @else
                                    <span class="badge bg-secondary">{{ $u->role }}</span>
                                @endif
                            </td>
                            <td>
                                @if ($u->perumahans->count())
                                    @foreach ($u->perumahans as $perumahan)
                                        <span class="badge bg-success">{{ $perumahan->perumahan }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if(in_array($u->role, ['sales', 'salesAdmin']))
                                    <div>
                                        <strong>Kode:</strong>
                                        <code>{{ $u->code ?? $u->email }}</code>
                                    </div>
                                    <div class="mt-1">
                                        <a href="{{ route('admin.salesAffiliates', $u->id) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-people"></i>
                                            Lihat Affiliate ({{ $u->affiliatesReferred->count() }})
                                        </a>
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.editUser', ['id' => $u->id]) }}"
                                       class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    @if (auth()->user()->role !== 'salesAdmin')
                                    <form onsubmit="return confirm('Apakah anda yakin ingin menghapus data?')"
                                          class="d-inline"
                                          action="{{ route('admin.deleteUser') }}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{ $u->id }}">
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

		<div class="d-flex align-items-end flex-column p-2 mb-2">
		</div>

  </div>
</div>

</section>
@endsection
