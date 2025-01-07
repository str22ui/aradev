<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>No Hp</th>
            <th>Perumahan</th>
            <th>Sumber Informasi</th>
            <th>PIC</th>
            <th>Follow Up</th>
            <th class="koresponden-col">Koresponden</th>
            {{-- <th>Keterangan Tambahan</th> --}}
            <th>Status</th>
            <th>Alasan</th>
            <th>Tanggal</th>
            <th>Update</th>
            {{-- @if(auth()->user()->role === 'admin'|| Auth::user()->role == 'salesAdmin' || Auth::user()->role == 'sales') --}}
            <th>Opsi</th>
            {{-- @endif --}}
        </tr>
    </thead>

    <tbody>
        @if ($report->count() > 0)
            @foreach ($report as $r)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $r->konsumen->nama_konsumen }}</td>
                    <td>{{ $r->konsumen->no_hp ?? 'N/A' }}</td>
                    <td>{{ $r->konsumen->perumahan }}</td>
                    <td>{{ $r->konsumen->sumber_informasi }}</td>
                    <td>
                        <ul class="custom-list">
                            @foreach (explode("\n", $r->pic) as $pic)
                                <li>{{ $pic }}</li>
                            @endforeach
                        </ul>
                    </td>

                    <td>
                        <ul class="custom-list">
                            @foreach (explode("\n", $r->follow_up) as $followUp)
                                <li>{{ $followUp }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="koresponden-col">
                        <ul class="custom-list">
                            @foreach (explode("\n", $r->koresponden) as $koresponden)
                                <li>{{ $koresponden }}</li>
                            @endforeach
                        </ul>
                    </td>

                    <td>
                        <ul class="custom-list">
                            @foreach (explode("\n", $r->status) as $status)
                                <li>{{ $status }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <ul class="custom-list">
                            @foreach (explode("\n", $r->alasan) as $alasan)
                                <li>{{ $alasan }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <ul class="custom-list">
                            @foreach (explode("\n", $r->tanggal) as $tanggal)
                                <li>{{ \Carbon\Carbon::parse($tanggal)->format('Y/m/d') }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <ul class="custom-list">
                            @foreach (explode("\n", $r->updated) as $updated)
                                <li>{{ \Carbon\Carbon::parse($updated)->format('Y/m/d') }}</li>
                            @endforeach
                        </ul>
                    </td>
                    {{-- @if(auth()->user()->role === 'admin'|| Auth::user()->role == 'salesAdmin' || Auth::user()->role == 'sales') --}}
                    <td>
                          {{-- @if(auth()->user()->role === 'admin') --}}
                        {{-- <form method="POST" action="/reports/{{ $r->id }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </form> --}}
                        <a href="{{ route('admin.editReport', ['id' => $r->id]) }}">
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </a>
                        {{-- @endif --}}
                        <form method="POST" action="/addReports/{{ $r->id }}">
                            @csrf
                            <button type="submit" class="btn btn-success">Add</button>
                        </form>

                    </td>
                    {{-- @endif --}}
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="13">Tidak ada data report tersedia.</td>
            </tr>
        @endif
    </tbody>
</table>
