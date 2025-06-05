<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th class="col-sm-1">No</th>
            <th class="col-md-1">Nama </th>
            <th class="col-md-1">No Kavling</th>
            <th class="col-md-1">Perumahan</th>
            <th class="col-md-1">Sumber Informasi</th>
            <th class="col-md-2 ">Payment</th>
            <th class="col-md-2">Income</th>
            <th class="col-md-2">DP</th>
            <th class="col-md-2">Tanggal</th>
             @if (auth()->user()->role !== 'salesAdmin')
                    <th class="col-md-2">User</th>
            @endif
            <th class="col-md-2">Action</th>


        </tr>
    </thead>
    <tbody>
        @foreach ($penawaran as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>

                <td>{{ $p->nama }}</td>
                <td>{{ $p->rumah->no_kavling}}</td>
                <td>{{ $p->perumahan->perumahan }}</td>

                <td>{{ $p->sumber_informasi}}</td>
                <td>{{ $p->payment }}</td>
                <td>{{ $p->income }}</td>
                <td>{{ $p->dp }}</td>
                <td>{{ $p->created_at->format('d/m/y') }}</td>
                 @if (auth()->user()->role !== 'salesAdmin')
                        <td>
                            <div class="d-flex flex-column">
                                <strong class="mb-1">{{ $p->user ? $p->user->name : '-' }}</strong>
                                <form action="{{ route('admin.updateUserIdPenawaran', ['id' => $p->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="user_id" onchange="this.form.submit()" class="form-select form-select-sm">
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" {{ $p->user_id == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                        </td>
                        @endif
                <td>
                        <a href="{{ route('admin.editPenawaran', ['id' => $p->id]) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="{{ url('/penawaran/pdf/' . $p->id) }}" class="btn btn-primary btn-sm"  data-bs-toggle="tooltip" title="Download PDF">
                        <i class="bi bi-file-earmark-pdf"></i>
                    </a>

                    @if (auth()->user()->role !== 'salesAdmin')
                    <form onsubmit="return confirm('Apakah anda yakin ingin menghapus data?')" class="d-inline" action="{{ route('admin.deletePenawaran') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <!-- Input untuk mengirim ID perumahan yang ingin dihapus -->
                        <input type="hidden" name="id" value="{{ $p->id }}">
                        <button type="submit" name="submit" class="btn btn-danger btn-sm"  data-bs-toggle="tooltip" title="Delete"><i class="bi bi-trash-fill"></i></button>
                    </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>

</table>
