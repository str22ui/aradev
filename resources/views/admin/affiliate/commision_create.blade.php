@extends('admin.layouts.index', ['title' => 'Tambah Komisi Affiliate', 'page_heading' => 'Tambah Komisi Affiliate'])

@section('content')
<section class="row">
    <div class="container mt-4">

        {{-- Form Tambah Komisi --}}
        <form action="{{ route('admin.storeCommission', $affiliate->id) }}" method="POST">
            @csrf
            <input type="hidden" name="affiliate_id" value="{{ $affiliate->id }}">

            <div class="card mb-4">
                <div class="card-body">
                    <p><strong>Affiliate :</strong> {{ $affiliate->name }}</p>
                    <p><strong>Kode:</strong> {{ $affiliate->code }}</p>
                    <p><strong>No HP:</strong> {{ $affiliate->phone }}</p>

                    {{-- Pilihan Perumahan --}}
                    <label for="perumahan_id" class="form-label">Pilih Perumahan</label>
                    <select id="perumahan_id" name="perumahan_id" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        @foreach ($perumahan as $item)
                            <option value="{{ $item->id }}" data-harga="{{ $item->harga }}">
                                {{ $item->perumahan }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Input Komisi --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Form Tambah Komisi</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="bulan" class="form-label">Periode Bulan</label>
                        <input type="month" name="bulan" id="bulan" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="harga_pricelist" class="form-label">Harga Pricelist</label>
                        <input type="number" name="harga_pricelist" id="harga_pricelist" class="form-control" required readonly>
                    </div>

                    <div class="mb-3">
                        <label for="biaya_legalitas" class="form-label">Biaya Legalitas</label>
                        <input type="number" name="biaya_legalitas" id="biaya_legalitas" class="form-control" value="0">
                    </div>

                    <div class="mb-3">
                        <label for="net_price" class="form-label">Net Price</label>
                        <input type="number" name="net_price" id="net_price" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="fee_2_5" class="form-label">Fee 2.5%</label>
                        <input type="number" name="fee_2_5" id="fee_2_5" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="fee_affiliate_30" class="form-label">Fee Affiliate 30%</label>
                        <input type="number" name="fee_affiliate_30" id="fee_affiliate_30" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="sub_total_bulanan" class="form-label">Sub Total Bulanan</label>
                        <input type="number" name="sub_total_bulanan" id="sub_total_bulanan" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="total" class="form-label">Total (semua fee)</label>
                        <input type="number" name="total" id="total" class="form-control" readonly>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan Komisi
                    </button>
                    <a href="{{ route('admin.affiliate') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </form>

        {{-- Tabel Data Komisi --}}
        <div class="card">
            <div class="card-header">
                <h5>Riwayat Komisi</h5>
            </div>
            <div class="card-body">
                @if($commissions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Periode</th>
                                    <th>Perumahan</th>
                                    <th>Harga Pricelist</th>
                                    <th>Biaya Legalitas</th>
                                    <th>Net Price</th>
                                    <th>Fee 2.5%</th>
                                    <th>Fee Affiliate 30%</th>
                                    <th>Sub Total</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($commissions as $key => $commission)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($commission->bulan)->format('F Y') }}</td>
                                        <td>{{ $commission->perumahan->perumahan ?? '-' }}</td>
                                        <td>Rp {{ number_format($commission->harga_pricelist, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($commission->biaya_legalitas, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($commission->net_price, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($commission->fee_2_5, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($commission->fee_affiliate_30, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($commission->sub_total_bulanan, 0, ',', '.') }}</td>
                                        <td><strong>Rp {{ number_format($commission->total, 0, ',', '.') }}</strong></td>
                                        <td>
                                            <form action="{{ route('admin.deleteCommission', $commission->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-info">
                                    <th colspan="9" class="text-end">Grand Total:</th>
                                    <th colspan="2">
                                        <strong>Rp {{ number_format($commissions->sum('total'), 0, ',', '.') }}</strong>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Belum ada data komisi untuk affiliate ini.
                    </div>
                @endif
            </div>
        </div>

    </div>
</section>

{{-- Script perhitungan otomatis --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const perumahanSelect = document.getElementById("perumahan_id");
    const hargaPricelist = document.getElementById("harga_pricelist");
    const biayaLegalitas = document.getElementById("biaya_legalitas");
    const netPrice = document.getElementById("net_price");
    const fee2_5 = document.getElementById("fee_2_5");
    const feeAffiliate30 = document.getElementById("fee_affiliate_30");
    const subTotal = document.getElementById("sub_total_bulanan");
    const total = document.getElementById("total");

    function calculateAll() {
        const harga = parseFloat(hargaPricelist.value) || 0;
        const legal = parseFloat(biayaLegalitas.value) || 0;

        const net = harga - legal;
        const fee25 = net * 0.025;
        const feeAffiliate = fee25 * 0.3;
        const subTotalValue = feeAffiliate;
        const totalValue = fee25 + feeAffiliate;

        netPrice.value = net.toFixed(0);
        fee2_5.value = fee25.toFixed(0);
        feeAffiliate30.value = feeAffiliate.toFixed(0);
        subTotal.value = subTotalValue.toFixed(0);
        total.value = totalValue.toFixed(0);
    }

    // Saat perumahan diganti → ambil harga otomatis
    perumahanSelect.addEventListener("change", function () {
        const selected = this.options[this.selectedIndex];
        const harga = selected.getAttribute("data-harga");
        hargaPricelist.value = harga ? harga : "";
        calculateAll();
    });

    // Jika biaya legalitas diubah → hitung ulang
    biayaLegalitas.addEventListener("input", calculateAll);
});
</script>

@endsection
