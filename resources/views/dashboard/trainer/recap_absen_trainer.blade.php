<!DOCTYPE html>
<html>

<head>
    <title>Laporan Absen Alsav</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }
    </style>
    <center>
        <h5>Membuat Laporan Absen</h4>
            <h6><a target="_blank" href="https://alsavedutech.com">https://alsavedutech.com</a>
        </h5>
    </center>

    <table class='table table-bordered'>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Trainer</th>
                <th>Kelas</th>
                <th>Tanggal</th>
                <th>Jam Mulai</th>
                <th>Jam Berakhir</th>
                <th>Hari</th>
                <th>Status Kelas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($absenExportToPDF as $export)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $export->user->name }}</td>
                    <td>{{ $export->jadwal->kelas->nama_kelas }}</td>
                    <td>{{ $export->jadwal->tanggal_jadwal_kelas }}</td>
                    <td>{{ $export->jadwal->jam_mulai_jadwal_kelas }}</td>
                    <td>{{ $export->jadwal->jam_akhir_jadwal_kelas }}</td>
                    <td>{{ $export->jadwal->hari_jadwal_kelas }}</td>
                    <td>{{ $export->jadwal->kelas->status_kelas }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
