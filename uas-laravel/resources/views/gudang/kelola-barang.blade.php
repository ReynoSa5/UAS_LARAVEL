<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Kelola Barang</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
</head>

<body style="background: #f8f9fa;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 d-flex flex-column align-items-center justify-content-center min-vh-100 text-center"
                style="background: #dbeeff;">
                <h4 class="fw-bold mb-4" style="font-size:2rem;">GUDANG</h4>
                <img src="/assets/images/warehouse.png" alt="Gudang Icon" class="img-fluid mb-3" style="width: 100px;">
                <div class="fw-bold mb-5" style="font-size:1.3rem;">KELOLA BARANG</div>
                <form action="{{ url('logout') }}" method="POST" style="width:100%;">
                    @csrf
                    <button class="btn w-100"
                        style="background:#90caff;color:#000;border-radius:8px;font-weight:bold;">Logout</button>
                </form>
            </div>
            <div class="col-md-9 p-4">
                <h3 class="mb-4 fw-bold">Kelola Barang</h3>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif
                <form action="" method="POST" id="formBarang">
                    @csrf
                    <input type="hidden" name="id_barang" id="id_barang">
                    <div class="row mb-3">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Kode Barang</label>
                            <input type="text" class="form-control" name="kode_barang" id="kode_barang"
                                placeholder="Masukkan kode barang" value="{{ old('kode_barang') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Jumlah Barang</label>
                            <input type="number" class="form-control" name="jumlah_barang" id="jumlah_barang"
                                placeholder="Masukkan jumlah barang" value="{{ old('jumlah_barang') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" name="nama_barang" id="nama_barang"
                                placeholder="Masukkan nama barang" value="{{ old('nama_barang') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Satuan</label>
                            <select class="form-select" name="satuan" id="satuan">
                                <option value="">  Pilih Satuan  </option>
                                <option value="pcs" {{ old('satuan') == 'pcs' ? 'selected' : '' }}>Pcs</option>
                                <option value="box" {{ old('satuan') == 'box' ? 'selected' : '' }}>Box</option>
                                <option value="botol" {{ old('satuan') == 'botol' ? 'selected' : '' }}>Botol</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Expired Date</label>
                            <input type="date" class="form-control" name="expired_date" id="expired_date"
                                placeholder="Tanggal kadaluarsa" value="{{ old('expired_date') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Harga Per Satuan</label>
                            <input type="text" class="form-control" name="harga_satuan" id="harga_satuan"
                                placeholder="Masukkan harga per satuan" value="{{ old('harga_satuan') }}">
                        </div>
                    </div>
                    <div class="d-flex gap-3 mb-4">
                        <button class="btn btn-info text-white px-5" type="submit" formaction=""
                            formmethod="POST">Tambah</button>
                        <button class="btn btn-info text-white px-5" type="submit"
                            formaction="{{ url('gudang/kelola-barang/update') }}" formmethod="POST"
                            onclick="return confirm('Yakin ingin edit barang ini?')">Edit</button>
                        <button class="btn btn-info text-white px-5" type="submit"
                            formaction="{{ url('gudang/kelola-barang/delete') }}" formmethod="POST"
                            onclick="return confirm('Yakin ingin hapus barang ini?')">Hapus</button>
                    </div>
                </form>

                <form method="GET" action="">
                    <div class="mb-3">
                        <input type="text" class="form-control" name="q" value="{{ request('q') }}"
                            placeholder="Cari barang" oninput="this.form.submit()">
                    </div>
                </form>

                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>ID Barang</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Expired Date</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Harga Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangs as $barang)
                            <tr style="cursor:pointer;"
                                onclick="isiFormBarang('{{ $barang->id_barang }}', '{{ $barang->kode_barang }}', '{{ $barang->nama_barang }}', '{{ $barang->expired_date }}', '{{ $barang->jumlah_barang }}', '{{ $barang->satuan }}', '{{ $barang->harga_satuan }}')">
                                <td>{{ $barang->id_barang }}</td>
                                <td>{{ $barang->kode_barang }}</td>
                                <td>{{ $barang->nama_barang }}</td>
                                <td>{{ $barang->expired_date }}</td>
                                <td>{{ $barang->jumlah_barang }}</td>
                                <td>{{ $barang->satuan }}</td>
                                <td>{{ $barang->harga_satuan }}</td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>

                <script>
                    function isiFormBarang(id, kode, nama, expired, jumlah, satuan, harga) {
                        document.getElementById('id_barang').value = id;
                        document.getElementById('kode_barang').value = kode;
                        document.getElementById('nama_barang').value = nama;
                        document.getElementById('expired_date').value = expired;
                        document.getElementById('jumlah_barang').value = jumlah;
                        document.getElementById('satuan').value = satuan;
                        document.getElementById('harga_satuan').value = harga;
                    }
                </script>
            </div>
        </div>
    </div>
</body>

</html>
