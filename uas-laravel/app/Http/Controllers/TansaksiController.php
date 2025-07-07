<?php

namespace App\Http\Controllers;

use App\Models\TableTransaksi;
use App\Models\TableBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TansaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = TableTransaksi::query();
        if ($request->filled('start')) {
            $query->whereDate('tgl_transaksi', '>=', $request->start);
        }
        if ($request->filled('end')) {
            $query->whereDate('tgl_transaksi', '<=', $request->end);
        }
        $transaksis = $query->get();
        return view('admin.kelola-laporan', compact('transaksis'));
    }

    public function formTransaksi()
    {
        $kasir = Auth::user();
        $no_transaksi = 'TR-' . date('Ymd-His');
        $barangs = TableBarang::all();
        $keranjang = Session::get('keranjang', []);
        $total_harga = collect($keranjang)->sum('subtotal');
        return view('kasir.kelola-transaksi', compact('kasir', 'no_transaksi', 'barangs', 'keranjang', 'total_harga'));
    }

    public function tambahKeranjang(Request $request)
    {
        $barang = TableBarang::findOrFail($request->kode_barang);
        $keranjang = Session::get('keranjang', []);
        $qty = $request->quantitas;
        $subtotal = $barang->harga_satuan * $qty;
        $keranjang[] = [
            'no_transaksi' => uniqid('TR-'),
            'id_barang' => $barang->id_barang,
            'kode_barang' => $barang->kode_barang,
            'nama_barang' => $barang->nama_barang,
            'harga_satuan' => $barang->harga_satuan,
            'quantitas' => $qty,
            'subtotal' => $subtotal
        ];
        Session::put('keranjang', $keranjang);
        return redirect(url('kasir/kelola-transaksi'))->with('success', 'Barang berhasil ditambahkan ke keranjang!');
    }

    public function resetKeranjang()
    {
        Session::forget('keranjang');
        return redirect(url('kasir/kelola-transaksi'))->with('success', 'Keranjang berhasil direset!');
    }

    public function simpanTransaksi(Request $request)
    {
        $keranjang = Session::get('keranjang', []);
        $no_transaksi = 'TR-' . date('Ymd-His');
        foreach ($keranjang as $item) {
            TableTransaksi::create([
                'no_transaksi' => $no_transaksi,
                'tgl_transaksi' => now(),
                'total_bayar' => $item['subtotal'],
                'id_user' => Auth::user()->id_user, 
                'id_barang' => $item['id_barang'],
            ]);
        }
        Session::forget('keranjang');
        return redirect(url('kasir/kelola-transaksi'))->with('success', 'Transaksi berhasil disimpan!');

    }
}
