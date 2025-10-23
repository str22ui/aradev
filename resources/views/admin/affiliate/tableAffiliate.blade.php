<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th class="col-sm-1">No</th>
            <th class="col-md-1">Nama </th>
            <th class="col-md-2">Phone</th>
            <th class="col-md-2 ">referreed_by_id</th>
            <th class="col-md-2">total_sales</th>
            <th class="col-md-2">total_commission</th>
            <th class="col-md-2">Tanggal Join</th>
            <th class="col-md-2">Perumahan</th>
            <th class="col-md-3">Action</th>

        </tr>
    </thead>

    <tbody>
        @foreach ($affiliate as $a)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $a->name }}</td>
                <td>{{ $a->phone }}</td>
                <td>{{ $a->referred_by_name ?? '-' }}</td>
                <td>{{ $a->total_sales }}</td>
                <td>{{ $a->total_commission }}</td>
              <td>{{ \Carbon\Carbon::parse($a->joined_at)->format('d/m/y') }}</td>
                
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
                 <td>

                    <a href="{{ route('admin.editAffiliate', ['id' => $a->id]) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form onsubmit="return confirm('Apakah anda yakin ingin menghapus data?')" class="d-inline" action="{{ route('admin.deleteAffiliate') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <!-- Input untuk mengirim ID perumahan yang ingin dihapus -->
                        <input type="hidden" name="id" value="{{ $a->id }}">
                        <button type="submit" name="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></button>
                    </form>


                </td>
            </tr>
        @endforeach
    </tbody>

</table>
