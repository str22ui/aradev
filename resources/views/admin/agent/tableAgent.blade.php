<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th class="col-sm-1">No</th>
            <th class="col-md-2">Nama </th>
            <th class="col-md-2">Kantor</th>
            <th class="col-md-2">Tipe</th>
            <th class="col-md-2 ">No HP</th>
            <th class="col-md-2">Alamat</th>
            <th class="col-md-2">Perumahan</th>
            <th class="col-md-2">Tanggal</th>
            <th class="col-md-3">Action</th>

        </tr>
    </thead>

    <tbody>
        @foreach ($agents as $a)
            <tr>
                <td>{{ $loop->iteration }}</td>

                <td>{{ $a->nama }}</td>
                <td>{{ $a->kantor }}</td>
                <td>{{ $a->tipe }}</td>
                <td>{{ $a->no_hp }}</td>
                <td>{{ $a->alamat }}</td>
                <td>
                    @php
                        $perumahanIds = json_decode($a->perumahan_id, true); // Decode JSON
                        $perumahans = $perumahan; // Pastikan $perumahan berisi koleksi data perumahan
                    @endphp

                    @if (is_array($perumahanIds) && $perumahans)
                        @foreach ($perumahanIds as $id)
                            @php
                                $perumahan = $perumahans->firstWhere('id', $id); // Cari perumahan berdasarkan ID
                            @endphp
                            @if ($perumahan)
                                <span class="badge bg-info text-dark">{{ $perumahan->perumahan }}</span>
                            @else
                                <span class="badge bg-danger text-white">Perumahan Tidak Ditemukan</span>
                            @endif
                        @endforeach
                    @else
                        <span class="text-muted">N/A</span>
                    @endif
                </td>
                <td>{{ $a->created_at->format('d/m/y') }}</td>
                <td>
                    {{-- <a href='{{ route('admin.showTeacher', ['management' => $m->slug])  }}' class="btn btn-primary btn-sm"><i class="bi bi-eye-fill"></i></a> --}}
                    {{-- <a href='#' class="btn btn-primary btn-sm"><i class="bi bi-eye-fill"></i></a> --}}
                    {{-- <a href="{{ route('admin.editTeacher', ['management' => $m->slug]) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a> --}}
                    <a href="{{ route('admin.editAgent', ['id' => $a->id]) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    @if (auth()->user()->role !== 'salesAdmin')
                    <form onsubmit="return confirm('Apakah anda yakin ingin menghapus data?')" class="d-inline" action="{{ route('admin.deleteAgent') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <!-- Input untuk mengirim ID perumahan yang ingin dihapus -->
                        <input type="hidden" name="id" value="{{ $a->id }}">
                        <button type="submit" name="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></button>
                    </form>
                    @endif

                </td>
            </tr>
        @endforeach
    </tbody>

</table>
