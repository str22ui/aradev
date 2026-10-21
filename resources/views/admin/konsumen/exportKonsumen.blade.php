<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Perumahan</th>
            <th>No HP</th>
            <th>Email</th>
            <th>Agent</th>
            <th>Affiliate</th>
            <th>Tanggal</th>
            <th>Diinput Oleh</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($konsumen as $k)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $k->nama_konsumen }}</td>
                <td>{{ $k->perumahan }}</td>
                <td>
                    @if (auth()->user()->role === 'sales')
                        {{ strlen($k->no_hp) >= 3 ? substr($k->no_hp, 0, -3) . 'xxx' : 'xxx' }}
                    @else
                        {{ $k->no_hp }}
                    @endif
                </td>
                <td>{{ $k->email }}</td>
                <td>{{ $k->agent ? $k->agent->nama : 'No Data' }}</td>
                <td>{{ $k->affiliate ? $k->affiliate->name : 'No Data' }}</td>
                <td>{{ $k->created_at ? $k->created_at->format('d/m/Y') : '-' }}</td>
                <td>{{ $k->user ? $k->user->name : 'Tidak diketahui' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
