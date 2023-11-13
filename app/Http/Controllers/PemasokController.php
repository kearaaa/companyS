<?php

namespace App\Http\Controllers;

use App\Models\Pemasok;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PemasokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $pemasok = Pemasok::with('produk')->get();
        $produk = Produk::all();
        return view('pemasok.pemasok', [
            'pemasok' => $pemasok,
            'produk' => $produk
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
            'nama_pemasok' => 'required|string|unique:tb_pemasok,nama_pemasok,except,id_pemasok',
            'alamat' => 'required|string',
            'email' => 'required|email|unique:tb_pemasok,email,except,id_pemasok',
            'id_produk' => 'required|exists:tb_produk,id_produk'
        ]);

        $pemasok = Pemasok::create($request->all());

        if ($pemasok) {
            Session::flash('status', 'success');
            Session::flash('message', 'data berhasil ditambahkan');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Pemasok $pemasok)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        //
        $pemasok = Pemasok::findOrFail($id);
        $produk = Produk::all();
        return view('pemasok.edit', [
            'pemasok' => $pemasok,
            'produk' => $produk
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //

        $request->validate([
            'nama_pemasok' => 'required|string',
            'alamat' => 'required|string',
            'email' => 'required|email',
            'id_produk' => 'required|exists:tb_produk,id_produk'
        ]);

        $pemasok = Pemasok::findOrFail($id);
        $pemasok->update($request->all());

        if ($pemasok) {
            Session::flash('status', 'success');
            Session::flash('message', 'data berhasil diubah');
        }
        return redirect('/pemasok');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $pemasok = Pemasok::findOrFail($id);
        try {
            $pemasok->delete();
            Session::flash('status', 'success');
            Session::flash('message', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Gagal menghapus data: data ini sedang dipakai di tabel lain');
            return redirect('/pemasok');
        }
        return redirect('/pemasok');
    }
}
