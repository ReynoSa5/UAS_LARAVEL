<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row min-vh-100">
            <div class="col-md-3 col-lg-2 bg-info-subtle p-4 min-vh-100 d-flex flex-column align-items-center">
                <div class="fs-2 fw-bold text-dark mb-4">
                    Admin
                </div>
                <div class="text-center mb-5 position-relative">
                    <div class="bg-white rounded-circle p-2 d-inline-flex justify-content-center align-items-center"
                        style="width: 120px; height: 120px;">
                        <img src="/assets/images/man.png" class="rounded-circle" alt="User Avatar"
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
                    @csrf
                    <button class="btn btn-info text-white fw-bold w-100 mb-3 py-3" type="submit">Logout</button>
                </form>
            </div>

            <div class="col-md-9 col-lg-10 p-4 bg-light">
                <h2 class="fw-bold mb-4 text-center">Laporan Penjualan</h2>

                <form method="GET" action="">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="startDate" class="form-label">Tanggal Awal</label>
                            <input type="date" class="form-control" id="startDate" name="start"
                                value="{{ request('start') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="endDate" class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="endDate" name="end"
                                value="{{ request('end') }}">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button class="btn btn-info text-white fw-bold w-100" type="submit">Filter</button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered text-center">
                        <thead class="table-secondary">
                            <tr>
                                <th>ID Transaksi</th>
                                <th>Tanggal Transaksi</th>
                                <th>Total Pembayaran</th>
                                <th>Nama Kasir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksis as $t)
                            <tr>
                                <td>{{ $t->no_transaksi }}</td>
                                <td>{{ \Carbon\Carbon::parse($t->tgl_transaksi)->translatedFormat('l, d/m') }}</td>
                                <td>Rp. {{ number_format($t->total_bayar, 0, ',', '.') }}</td>
                                <td>{{ $t->user->nama ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">Tidak ada data transaksi</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="row align-items-start">
                    <div class="col-md-8">
                        <h6 class="fw-bold">Omset</h6>
                        <div class="bg-white border rounded p-4" style="height: 320px;">
                            <canvas id="omsetChart" height="280" style="display:none;"></canvas>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center justify-content-center">
                        <button id="generateChartBtn" class="btn btn-info text-white fw-bold px-4 py-2">Generate</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/assets/js/chart.min.js"></script>
    <script>
        const labels = [
            @foreach($transaksis->groupBy(function($t) { return \Carbon\Carbon::parse($t->tgl_transaksi)->format('d/m'); }) as $tgl => $trx)
                '{{ $tgl }}',
            @endforeach
        ];
        const data = [
            @foreach($transaksis->groupBy(function($t) { return \Carbon\Carbon::parse($t->tgl_transaksi)->format('d/m'); }) as $trx)
                {{ $trx->sum('total_bayar') }},
            @endforeach
        ];
        let chartInstance = null;
        document.getElementById('generateChartBtn').addEventListener('click', function() {
            const canvas = document.getElementById('omsetChart');
            canvas.style.display = 'block';
            if(chartInstance) chartInstance.destroy();
            const ctx = canvas.getContext('2d');
            chartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Omset Harian',
                        data: data,
                        backgroundColor: '#7EC6F3',
                        borderColor: '#3498db',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        title: { display: false }
                    },
                    layout: {
                        padding: 20
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp. ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>
