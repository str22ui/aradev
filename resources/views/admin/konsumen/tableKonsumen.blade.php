<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th class="col-sm-1">No</th>
            <th class="col-md-2">Nama</th>
            <th class="col-md-2">Perumahan</th>
            <th class="col-md-2">No HP</th>
            <th class="col-md-2">Email</th>
            <th class="col-md-1">Agent</th>
            <th class="col-md-1">Reseller</th>
            <th class="col-md-2">Tanggal</th>
            <th class="col-md-2">Action</th>

        </tr>
    </thead>

    <tbody>
        @if ($konsumen->count() > 0)
            @foreach ($konsumen as $k)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $k->nama_konsumen }}</td>
                    <td>{{ $k->perumahan }}</td>
                    <td>{{ $k->no_hp }}</td>
                    <td>{{ $k->email }}</td>
                    <td>{{ $k->agent->nama ?? 'No Data'}}</td>
                    <td>{{ $k->reseller->nama ?? 'No Data'}}</td>
                    <td>{{ $k->created_at->format('d/m/y') }}</td>
                    <td>
                        {{-- <a href='' class="btn btn-primary btn-sm"><i class="bi bi-eye-fill"></i></a> --}}
                        {{-- <a href='{{ route('admin.showEbook', ['ebook' => $e->slug])  }}' class="btn btn-primary btn-sm"><i class="bi bi-eye-fill"></i></a> --}}
                        <a href="{{ route('admin.editKonsumen', ['id' => $k->id]) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        @if (auth()->user()->role !== 'salesAdmin')
                        <form onsubmit="return confirm('Apakah anda yakin ingin menghapus data?')" class="d-inline" action="{{ route('admin.deleteKonsumen') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <!-- Input untuk mengirim ID perumahan yang ingin dihapus -->
                            <input type="hidden" name="id" value="{{ $k->id }}">
                            <button type="submit" name="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></button>
                        </form>
                        @endif
                    </td>

                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="13">Tidak ada data konsumen tersedia.</td>
            </tr>
        @endif
    </tbody>
</table>
