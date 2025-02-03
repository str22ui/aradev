<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konsumen Survey</title>
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

      
        .container {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .footer {
            width: 100%;
        }

        .note {
            font-size: 12px;
            text-align: left;
        }

        .signature {
            margin-top: 40px;
        }

        .signature span {
            font-weight: bold;
        }
        .title{
            text-align: center;
            font-weight: bold;
            font-size: 16px;
        }
        .h1{
            font-weight: bold;
        }
        .nama{
            margin-bottom: 12px;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="title">
            KONSUMEN SURVEY<br>
        </div>
        <div>
            {{-- <p>Nama Agent: {{ $survey->agent ? $survey->agent->nama : 'Tidak ada agent' }}</p> --}}
            <p class="h1">AGENT ARADEV PROPERTY</p>
        </div>
        <div class="content">
            <div class="nama"><span class="label">NAMA PERUMAHAN</span>: {{ $survey->perumahan }}</div>

            <table class="table-info">
                <!-- Baris 1: No Unit sampai Harga -->
                <tr class="row">
                    <td class="column">
                        <table>
                            <tr>
                                <td>Nama Konsumen</td>
                                <td>:</td>
                                <td>{{ $survey->nama_konsumen }}</td>
                            </tr>
                            <tr>
                                <td>Survey di Hari</td>
                                <td>:</td>
                                <td>{{ \Carbon\Carbon::parse($survey->tanggal_janjian)->locale('id')->isoFormat('dddd, DD/MM/YY') }}</td>
                            </tr>
                        </table>
                    </td>
                    <!-- Kolom kedua -->
                    <td class="column">
                        <table>
                            <tr>
                                <td>Domisili</td>
                                <td>:</td>
                                <td>{{ $survey->domisili}}</td>
                            </tr>
                            <tr>
                                <td>Jam</td>
                                <td>:</td>
                                <td>{{ \Carbon\Carbon::parse($survey->waktu_janjian)->format('H:i') }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div class="note">
            Catatan: informasi diatas adalah konfirmasi konsumen yang disampaikan di sistem kami. Perubahan waktu yang terjadi, sepenuhnya atas kemauan konsumen.
        </div>
    </div>
</body>
</html>
