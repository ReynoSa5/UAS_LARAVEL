<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Kelola User</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/template-2.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 bg-info-subtle p-4 min-vh-100 d-flex flex-column align-items-center">
                <div class="fs-2 fw-bold text-dark mb-4">Admin</div>
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
                    <button class="btn btn-info text-white fw-bold w-100 mb-3 py-3" type="submit">Logout</button>
                    @csrf
                </form>
            </div>

            <div class="col-md-9 p-4">
                <h3 class="mb-4">Kelola User</h3>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif
                <form action="" method="POST" id="formUser">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @csrf
                    <input type="hidden" name="id_user" id="id_user">
                    <div class="row mb-3">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tipe User</label>
                            <select class="form-select" name="tipe_user" id="tipe_user">
                                <option value="" disabled selected>Pilih tipe user</option>
                                <option value="admin">admin</option>
                                <option value="gudang">gudang</option>
                                <option value="kasir">kasir</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama" id="nama"
                                placeholder="Masukkan nama lengkap">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Telepon</label>
                            <input type="text" class="form-control" name="telpon" id="telpon"
                                placeholder="Contoh: 08123456789">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" class="form-control" name="alamat" id="alamat"
                                placeholder="Masukkan alamat user">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" id="username"
                                placeholder="Masukkan username">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Masukkan password ">
                        </div>
                    </div>
                    <div class="d-flex gap-3 mb-4">
                        <button class="btn btn-info text-white px-5" type="submit"
                            formaction="{{ url('admin/kelola-user') }}" formmethod="POST"
                            onclick="return confirm('Yakin ingin menambah user ini?')">Tambah</button>
                        <button class="btn btn-info text-white px-5" type="submit"
                            formaction="{{ url('admin/kelola-user/update') }}" formmethod="POST"
                            onclick="return confirm('Yakin ingin edit user ini?')">Edit</button>
                        <button class="btn btn-info text-white px-5" type="submit"
                            formaction="{{ url('admin/kelola-user/delete') }}" formmethod="POST"
                            onclick="return confirm('Yakin ingin hapus user ini?')">Hapus</button>
                    </div>
                </form>
                <script>
                    function isiForm(id, tipe_user, nama, alamat, telpon, username) {
                        document.getElementById('id_user').value = id;
                        document.getElementById('tipe_user').value = tipe_user;
                        document.getElementById('nama').value = nama;
                        document.getElementById('alamat').value = alamat;
                        document.getElementById('telpon').value = telpon;
                        document.getElementById('username').value = username;
                        document.getElementById('password').value = password;
                    }
                </script>

                <form method="GET" action="">
                    <div class="mb-3">
                        <input type="text" class="form-control" name="q" value="{{ request('q') }}"
                            placeholder="Cari user berdasarkan nama atau username" oninput="this.form.submit()">
                    </div>
                </form>

                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Id User</th>
                            <th>Tipe User</th>
                            <th>Nama User</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr style="cursor:pointer;"
                                onclick="isiForm('{{ $user->id_user }}', '{{ $user->tipe_user }}', '{{ $user->nama }}', '{{ $user->alamat }}', '{{ $user->telpon }}', '{{ $user->username }}')">
                                <td>{{ $user->id_user }}</td>
                                <td>{{ $user->tipe_user }}</td>
                                <td>{{ $user->nama }}</td>
                                <td>{{ $user->alamat }}</td>
                                <td>{{ $user->telpon }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
