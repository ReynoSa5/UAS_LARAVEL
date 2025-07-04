<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log Activity</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/template-2.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 bg-info-subtle p-4 min-vh-100 d-flex flex-column align-items-center">
                <div class="fs-2 fw-bold text-dark mb-4">
                    Admin
                </div>
                <div class="text-center mb-5 position-relative">
                    <div class="bg-white rounded-circle p-2 d-inline-flex justify-content-center align-items-center"
                        style="width: 120px; height: 120px;">
                        <img src="\assets\images\man.png" class="rounded-circle" alt="User Avatar"
                            style="width: 80px; height: 80px;">
                    </div>
                    <div class="position-absolute bottom-0 end-0 bg-success text-white rounded-circle p-1 d-flex justify-content-center align-items-center border border-2 border-info-subtle"
                        style="width: 35px; height: 35px; font-size: 1.1rem;">
                        <i class="fa-solid fa-gear"></i>
                    </div>
                </div>

                <a href="{{ url('admin/kelola-user') }}" class="btn btn-info text-white fw-bold w-100 mb-3 py-3">Kelola
                    User</a>
                <a href="{{ url('admin/kelola-laporan') }}"
                    class="btn btn-info text-white fw-bold w-100 mb-3 py-3">Kelola Laporan</a>
                <form action="{{ url('logout') }}" method="POST" class="w-100">
                    <button class="btn btn-info text-white fw-bold w-100 mb-3 py-3" type="submit">Logout</button>
                    @csrf
                </form>
            </div>

            <div class="col-md-9 col-lg-10 p-4 bg-white rounded shadow-sm my-3 mx-auto">
                <h2 class="fs-3 fw-bold text-dark mb-4">Log Activity</h2>

                <form method="GET" action="">
                    <div class="d-flex align-items-center mb-4">
                        <label for="tanggalFilter" class="form-label mb-0 me-3">Pilih Tanggal</label>
                        <input type="date" class="form-control me-3" id="tanggalFilter" name="tanggal"
                            value="{{ request('tanggal') }}" style="max-width: 200px;">
                        <button class="btn btn-info text-white fw-bold px-4 py-2" type="submit">Filter</button>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID Log</th>
                                <th>Username</th>
                                <th>Waktu</th>
                                <th>Aktivitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                                <tr>
                                    <td>{{ $log->id_log }}</td>
                                    <td>{{ $log->user ? $log->user->username : '-' }}</td>
                                    <td>{{ $log->waktu }}</td>
                                    <td>{{ $log->aktivitas }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
