<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $produk = Produk::with('perusahaan')->get();
        $perusahaan = Perusahaan::all();
        return view('produk.produk', [
            'produk' => $produk,
            'perusahaan' => $perusahaan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nama_produk' => 'required|string|unique:tb_produk,nama_produk,except,id_produk',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'id_perusahaan' => 'required|exists:tb_perusahaan,id_perusahaan',
        ]);

        $produk = Produk::create($request->all());

        if ($produk) {
            Session::flash('status', 'success');
            Session::flash('message', 'data berhasil ditambahkan');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        //
        $produk = Produk::findOrFail($id);
        $perusahaan = Perusahaan::all();
        return view('produk.edit', [
            'produk' => $produk,
            'perusahaan' => $perusahaan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'nama_produk' => 'required|string',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'id_perusahaan' => 'required|exists:tb_perusahaan,id_perusahaan',
        ]);
        
        $produk = Produk::findOrFail($id);
        $produk->update($request->all());

        if ($produk) {
            Session::flash('status', 'success');
            Session::flash('message', 'data berhasil diubah');
        }
        return redirect('/produk');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $produk = Produk::findOrFail($id);
        try {
            $produk->delete();
            Session::flash('status', 'success');
            Session::flash('message', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Gagal menghapus data: data ini sedang dipakai di tabel lain');
            return redirect('/produk');
        }

        return redirect('/produk');
    }
}
