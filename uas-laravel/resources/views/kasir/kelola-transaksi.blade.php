<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Kelola Transaksi</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 d-flex flex-column align-items-center justify-content-center min-vh-100 text-center"
                style="background: #dbeeff;">
                <h4 class="fw-bold mb-4" style="font-size:2rem;">KASIR</h4>
                <img src="/assets/images/cashier.png" alt="Gudang Icon" class="img-fluid mb-3" style="width: 100px;">
                <div class="fw-bold mb-5" style="font-size:1.3rem;">KELOLA TANSAKSI</div>
                <form action="{{ url('logout') }}" method="POST" style="width:100%;">
                    @csrf
                    <button class="btn w-100"
                        style="background:#7EC6F3;color:#222;border-radius:12px;font-weight:bold;min-width:120px;padding:10px 0;border:none;box-shadow:0 2px 8px #e3f2fd;"
                        type="submit">Logout</button>
                </form>
            </div>
            <div class="col-md-9 p-4">
                <h4 class="fw-bold mb-4">Form Transaksi</h4>
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Pilih Menu</label>
                        <form method="POST" action="{{ url('kasir/kelola-transaksi/tambah') }}">
                            @csrf
                            <select class="form-select mb-3" name="kode_barang" onchange="updateHarga(this)">
                                <option value="">Pilih Menu</option>
                                @foreach ($barangs as $barang)
                                <option value="{{ $barang->id_barang }}" data-harga="{{ $barang->harga_satuan }}">
                                    {{ $barang->kode_barang }} - {{ $barang->nama_barang }}</option>
                                @endforeach
                            </select>
                            <label class="form-label">Harga Satuan</label>
                            <input type="text" id="harga_satuan" class="form-control mb-3" value="" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label d-flex justify-content-between">
                            Quantitas <span class="badge text-bg-danger">Kasir 1</span>
                        </label>
                        <input type="number" name="quantitas" class="form-control mb-3" value="1" min="1"
                            required>
                        <label class="form-label">Total Harga</label>
                        <input type="text" id="total_harga" class="form-control mb-3" value="" readonly>
                        <div class="d-flex gap-3 mb-4">
                            <button type="submit" class="btn"
                                style="background:#7EC6F3;color:#222;border-radius:12px;font-weight:bold;min-width:120px;padding:10px 0;border:none;box-shadow:0 2px 8px #e3f2fd;">Tambah</button>
                            <button type="submit" formaction="{{ url('kasir/kelola-transaksi/reset') }}" formmethod="POST"
                                class="btn"
                                style="background:#7EC6F3;color:#222;border-radius:12px;font-weight:bold;min-width:120px;padding:10px 0;border:none;box-shadow:0 2px 8px #e3f2fd;"
                                onclick="document.querySelector('select[name=kode_barang]').removeAttribute('required')">Reset</button>
                        </div>
                        </form>
                    </div>
                </div>
                <table class="table table-bordered text-center">
                    <thead class="table-light">
                        <tr>
                            <th>No Transaksi</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Harga Satuan</th>
                            <th>Quantitas</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($keranjang as $item)
                        <tr>
                            <td>{{ $item['no_transaksi'] ?? '' }}</td>
                            <td>{{ $item['kode_barang'] }}</td>
                            <td>{{ $item['nama_barang'] }}</td>
                            <td>Rp. {{ number_format($item['harga_satuan'], 0, ',', '.') }}</td>
                            <td>{{ $item['quantitas'] }}</td>
                            <td>Rp. {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">Keranjang kosong</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="row my-4">
                    <div class="col-md-6">
                        <h5>Total Harga</h5>
                        <input type="text" id="total_harga_bayar" class="form-control fw-bold mb-2"
                            value="Rp. {{ number_format($total_harga, 0, ',', '.') }}" readonly>
                        <form id="form-bayar" onsubmit="return false;">
                            <label class="form-label">Jumlah Bayar</label>
                            <input type="number" id="jumlah_bayar" class="form-control mb-2"
                                placeholder="Masukkan jumlah bayar" min="0">
                            <button class="btn mt-2 w-100"
                                style="background:#7EC6F3;color:#222;border-radius:12px;font-weight:bold;min-width:120px;padding:10px 0;border:none;box-shadow:0 2px 8px #e3f2fd;"
                                onclick="hitungKembalian()">Bayar</button>
                            <div class="mt-2 d-flex justify-content-between">
                                <span>Kembalian</span>
                                <span id="kembalian_label">Rp. 0</span>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control mb-3" value="Rp. 0" readonly
                            style="visibility:hidden;">
                        <div class="d-flex gap-3">
                            <button class="btn w-50"
                                style="background:#7EC6F3;color:#222;border-radius:12px;font-weight:bold;min-width:120px;padding:10px 0;border:none;box-shadow:0 2px 8px #e3f2fd;"
                                onclick="window.print()" type="button">Print</button>
                            <form method="POST" action="{{ url('kasir/kelola-transaksi/simpan') }}"
                                style="display:inline;width:48%;">
                                @csrf
                                <input type="hidden" name="jumlah_bayar" id="jumlah_bayar_hidden">
                                <button class="btn w-100"
                                    style="background:#7EC6F3;color:#222;border-radius:12px;font-weight:bold;min-width:120px;padding:10px 0;border:none;box-shadow:0 2px 8px #e3f2fd;"
                                    type="submit"
                                    onclick="document.getElementById('jumlah_bayar_hidden').value=document.getElementById('jumlah_bayar').value">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function updateHarga(select) {
            var harga = select.options[select.selectedIndex].getAttribute('data-harga');
            document.getElementById('harga_satuan').value = harga ? 'Rp. ' + parseInt(harga).toLocaleString('id-ID') : '';
            var qty = document.querySelector('input[name=quantitas]').value;
            document.getElementById('total_harga').value = harga && qty ? 'Rp. ' + (parseInt(harga) * parseInt(qty))
                .toLocaleString('id-ID') : '';
        }
        document.querySelector('input[name=quantitas]').addEventListener('input', function() {
            var harga = document.querySelector('select[name=kode_barang]').options[document.querySelector(
                'select[name=kode_barang]').selectedIndex].getAttribute('data-harga');
            var qty = this.value;
            document.getElementById('total_harga').value = harga && qty ? 'Rp. ' + (parseInt(harga) * parseInt(qty))
                .toLocaleString('id-ID') : '';
        });

        function hitungKembalian() {
            var total = {{ $total_harga }};
            var bayar = parseInt(document.getElementById('jumlah_bayar').value) || 0;
            var kembali = bayar - total;
            document.getElementById('kembalian_label').innerText = 'Rp. ' + (kembali > 0 ? kembali.toLocaleString('id-ID') :
                '0');
        }
    </script>
</body>

</html>
