<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            position: relative;
        }
        .draft-watermark {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 48px;
            color: rgba(18, 183, 12, 0.3);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        td {
            border-top: 1px solid #e6e6e6;
        }
        .total-row {
            font-weight: bold;
        }
        @media print {
    /* Sembunyikan tombol cetak saat mencetak */
    #exportPdfBtn {
        display: none;
    }

    /* Sembunyikan watermark saat mencetak */
    .draft-watermark {
        display: none;
    }
}

    </style>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script> --}}
</head>
    <body>
        <div class="container">
            <div class="draft-watermark">APPROVE</div>
            <h1>Slip Gaji</h1>

            <h2>Data Karyawan</h2>
            <table>
                <tr>
                    <th>Nama</th>
                    <td>{{ $karyawan->nama }}</td>
                </tr>
                <tr>
                    <th>Jabatan</th>
                    <td>{{ $karyawan->jabatan }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $karyawan->status }}</td>
                </tr>
                <tr>
                <tr>
                    <th>Periode Gaji Bulan</th>
                    <td>{{ date('F', mktime(0, 0, 0, $periode_gaji, 1)) }}</td>
                </tr>
                <tr>
                    <th>Gaji Pokok</th>
                    <td>Rp {{ number_format($karyawan->gaji_pokok, 0, ',', '.') }} ({{ terbilang($karyawan->gaji_pokok) }})</td>
                </tr>
                <tr>
                    <th>Tunjangan</th>
                    <td>Rp {{ number_format($karyawan->tunjangan, 0, ',', '.') }} ({{ terbilang($karyawan->tunjangan) }})</td>
                </tr>
            </table>
            <h4>Komponen Penambah</h4>
            <table>
                <tr>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                </tr>
                <tr>
                    <td>Insentif</td>
                    <td>Rp {{ number_format($insentif, 0, ',', '.') }} ({{ terbilang($insentif) }})</td>
                </tr>
                <tr>
                    <td>Upah Lembur</td>
                    <td>Rp {{ number_format($upahLembur, 0, ',', '.') }} ({{ terbilang($upahLembur) }})</td>
                </tr>
            </table>

            <h4>Potongan</h4>
            <table>
                <tr>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                </tr>
                <tr>
                    <td>Potongan NWNP (Jumlah Hari Tidak Masuk)</td>
                    <td>{{ $jumlahHariTidakMasuk }} hari (Rp {{ number_format($potonganNWNP, 0, ',', '.') }}) ({{ terbilang($potonganNWNP) }})</td>
                </tr>
                <tr>
                    <td>Potongan BPJS</td>
                    <td>Rp {{ number_format($potonganBPJS, 0, ',', '.') }} ({{ terbilang($potonganBPJS) }})</td>
                </tr>
            </table>

            <h4>Total Gaji Perbulan</h4>
            <table>
                <tr class="total-row">
                    <td>Total Gaji</td>
                    <td>Rp {{ number_format($totalGaji, 0, ',', '.') }} ({{ terbilang($totalGaji) }})</td>
                </tr>
            </table>
            {{-- <form id="print"> --}}
                {{-- <button id="print" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px;">Export PDF</button> --}}
            {{-- </form> --}}
            <form id="print">
                <button id="exportPdfBtn" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px;">Export PDF</button>
            </form>
        </div>
        <script>
            const printBtn = document.getElementById('exportPdfBtn');
            printBtn.addEventListener('click', function () {
                window.print();
            });
        </script>
    
    </body>
</html>
