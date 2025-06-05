<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th class="col-sm-1">No</th>
            <th class="col-md-2">Nama</th>
            <th class="col-md-2">Perumahan</th>
            <th class="col-md-2">No HP</th>
            <th class="col-md-2">Sumber</th>
            <th class="col-md-1">Survey</th>
            <th class="col-md-1">Jam</th>
            <th class="col-md-1">Tanggal</th>
             @if (auth()->user()->role === 'admin')
                    <th class="col-md-2">User</th>
            @endif
            <th class="col-md-2">Action</th>

        </tr>
    </thead>

    <tbody>
        @foreach ($survey as $s)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $s->nama_konsumen }}</td>
            <td>{{ $s->perumahan }}</td>
           <td>
                @if (auth()->user()->role === 'sales')
                    {{ strlen($s->no_hp) >= 3 ? substr($s->no_hp, 0, -3) . 'xxx' : 'xxx' }}
                @else
                    {{ $s->no_hp }}
                @endif
            </td>

            <td>{{ $s->sumber_informasi }}</td>

            <td>{{ $s->tanggal_janjian }}</td>
            <td>{{ $s->waktu_janjian }}</td>
            <td>{{ $s->created_at->format('d/m/y') }}</td>
             @if (auth()->user()->role === 'admin')
                        <td>
                            <div class="d-flex flex-column">
                                <strong class="mb-1">{{ $s->user ? $s->user->name : '-' }}</strong>
                                <form action="{{ route('admin.updateUserIdSurvey', ['id' => $s->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="user_id" onchange="this.form.submit()" class="form-select form-select-sm">
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" {{ $s->user_id == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                        </td>
                        @endif
            {{-- <td>{{ $s->agent->nama ?? 'No Data'}}</td> --}}
            <td>
                {{-- <a href='' class="btn btn-primary btn-sm"><i class="bi bi-eye-fill"></i></a> --}}
                {{-- <a href='{{ route('admin.showEbook', ['ebook' => $e->slug])  }}' class="btn btn-primary btn-sm"><i class="bi bi-eye-fill"></i></a> --}}
                <a href="{{ route('admin.editSurvey', ['id' => $s->id]) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Edit">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <a href="{{ url('/survey/pdf/' . $s->id) }}" class="btn btn-primary btn-sm"  data-bs-toggle="tooltip" title="Download PDF">
                    <i class="bi bi-file-earmark-pdf"></i>
                </a>

                @if (auth()->user()->role === 'admin')
                <form onsubmit="return confirm('Apakah anda yakin ingin menghapus data?')" class="d-inline" action="{{ route('admin.deleteSurvey') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <!-- Input untuk mengirim ID perumahan yang ingin dihapus -->
                    <input type="hidden" name="id" value="{{ $s->id }}">
                    <button type="submit" name="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Delete"> <i class="bi bi-trash-fill"></i></button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
</tbody>

</table>
