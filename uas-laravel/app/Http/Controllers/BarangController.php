<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TableBarang;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = TableBarang::query();
        if ($request->filled('q')) {
            $query->where('nama_barang', 'like', $request->q . '%');
        }
        $barangs = $query->orderBy('id_barang', 'asc')->get();
        return view('gudang.kelola-barang', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:table_barangs,kode_barang',
            'nama_barang' => 'required',
            'jumlah_barang' => 'required|integer|min:1',
            'satuan' => 'required',
            'expired_date' => 'required|date',
            'harga_satuan' => 'required',
        ]);
        TableBarang::create($request->all());
        return redirect(url('gudang/kelola-barang'))->with('success', 'Barang berhasil ditambahkan.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|exists:table_barangs,id_barang',
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'jumlah_barang' => 'required|integer|min:1',
            'satuan' => 'required',
            'expired_date' => 'required|date',
            'harga_satuan' => 'required',
        ]);
        $barang = TableBarang::findOrFail($request->id_barang);
        $barang->update($request->all());
        return redirect(url('gudang/kelola-barang'))->with('success', 'Barang berhasil diupdate.');
    }

    public function destroy(Request $request)
    {
        $barang = TableBarang::findOrFail($request->id_barang);
        $barang->delete();
        return redirect(url('gudang/kelola-barang'))->with('success', 'Barang berhasil dihapus.');
    }
}
