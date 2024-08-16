<!DOCTYPE html>
<html>

<head>
    <title>Laporan Recap Sallary Alsav</title>
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
        <h5>Membuat Laporan Recap Sallary</h4>
            <h6><a target="_blank" href="https://alsavedutech.com">https://alsavedutech.com</a>
        </h5>
    </center>

    <table class='table table-bordered'>
        <thead>
            <tr>
                <th>No</th>
                <th>Trainer Name</th>
                <th>Level Trainer</th>
                <th>Sallary</th>
                <th>Meets</th>
                <th>Status Verify</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($RecapSallaryToPDF as $export)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $export->user->name }}</td>
                    <td>{{ $export->user->levelTrainer->nama_level }}</td>
                    <td>@mata_uang($export->total_gaji)</td>
                    <td>{{ count($export->assignedKelas->kelas->jadwalKelas) }}</td>
                    <td>{{ $export->status }}</td>
                    <td>{{ $export->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
