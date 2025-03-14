<!DOCTYPE html>
<html lang="id">

<!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZWTJ8TKN7L"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-ZWTJ8TKN7L');
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Penawaran</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.6;
            margin: 0 2cm;
        }

        h1 {
            font-family: 'Times New Roman', Times, serif;
            text-align: center;
            text-transform: uppercase;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .content {
            font-family: 'Times New Roman', Times, serif;
            margin-top: 10px;
        }

        .table-info {
            width: 100%;
            border-collapse: collapse;
        }

        .table-info td {
        padding: 5px;
        vertical-align: top;
        }



        .highlight {
            font-weight: bold;
        }

        .container {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .footer {
            width: 100%;
        }

        .note {


            font-size: 8px;
            text-align: left;
        }

        .signature {
            margin-top: 40px;
        }

        .signature span {
            font-weight: bold;
        }

    </style>
</head>
<body>
    <h1>SURAT PENAWARAN</h1>

    <p>Kepada Yth.<br>
    <span class="highlight">Marketing Shevia Heights</span><br>
    di tempat,</p>

    <p>Dengan ini perkenalkan saya:</p>
    <table class="table-info">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $penawaran->nama }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $penawaran->domisili }}</td>
        </tr>
        <tr>
            <td>No Tlp - Wa</td>
            <td>:</td>
            <td>{{ $penawaran->no_hp }}</td>
        </tr>
    </table>

    <p>Saya telah melakukan survey dan berkomunikasi dengan Pihak Marketing / Agen Shevia Heights yang bernama <span class="highlight">{{ $penawaran->agent->nama ?? 'N/A' }}</span> dan saya tertarik dengan unit yang ditawarkan.</p>

    <p>Melalui Surat ini, saya ingin mengajukan penawaran di Perumahan <span class="highlight">{{ $penawaran->perumahan->perumahan }}</span> yang berlokasi di <span class="highlight">{{ $penawaran->perumahan->lokasi }}</span>.</p>

    <p>Adapun penawaran unit yang saya ajukan adalah:</p>
    <table class="table-info">
        <!-- Baris 1: No Unit sampai Harga -->
        <tr class="row">
            <td class="column">
                <table>
                    <tr>
                        <td>No Unit</td>
                        <td>:</td>
                        <td>{{ $penawaran->rumah->no_kavling }}</td>
                    </tr>
                    <tr>
                        <td>L. Tanah</td>
                        <td>:</td>
                        <td>{{ $penawaran->rumah->luas_tanah }}</td>
                    </tr>
                    <tr>
                        <td>L. Bangunan</td>
                        <td>:</td>
                        <td>{{ $penawaran->rumah->luas_bangunan }}</td>
                    </tr>
                    <tr>
                        <td>Harga PL</td>
                        <td>:</td>
                        {{-- <td>{{ number_format($penawaran->rumah->harga, 0, ',', '.') }}</td> --}}
                        <td>{{ $penawaran->rumah->harga}}</td>
                    </tr>
                </table>
            </td>
            <!-- Kolom kedua -->
            <td class="column">
                <table>
                    <tr>
                        <td>Sistem Bayar</td>
                        <td>:</td>
                        <td>{{ $penawaran->payment }}</td>
                    </tr>
                    <tr>
                        <td>Income</td>
                        <td>:</td>
                        <td>{{ $penawaran->income }}</td>
                    </tr>
                    <tr>
                        <td>Pekerjaan</td>
                        <td>:</td>
                        <td>{{ $penawaran->pekerjaan }}</td>
                    </tr>
                    <tr>
                        <td>Harga Penawaran</td>
                        <td>:</td>
                        <td>{{ $penawaran->harga_pengajuan }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="content">
        <p>Demikian Surat Penawaran ini saya sampaikan, selanjutnya saya menunggu respon dari Pihak Shevia Heights untuk pembuatan simulasi pembayaran dan lain-lain dari pengajuan penawaran ini. Atas perhatian dan kerjasamanya, saya ucapkan terima kasih.</p>
    </div>

    <div class="container">
        <div class="footer w-1/2">
            <p>Tangerang Selatan, {{ now()->format('d M Y') }}</p>
            <p>Hormat saya,</p>
            <p class="signature">
                <span>{{ $penawaran->nama }}</span>
            </p>
            <p class="note"><strong>Catatan :</strong> Diskon, Promo dan lain-lainnya mengikuti waktu yang berlaku saat pengajuan penawaran ini.</p>

        </div>

    </div>


</body>
</html>
