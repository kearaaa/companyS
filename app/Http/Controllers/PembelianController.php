<?php

namespace App\Http\Controllers;

use App\Models\Pemasok;
use App\Models\Pembelian;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $pembelian = Pembelian::with('pemasok')->get();
        $pemasok = Pemasok::all();
        return view('pembelian.pembelian', [
            'pembelian' => $pembelian,
            'pemasok' => $pemasok
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
            'tgl_pembelian' => 'required|date',
            'id_pemasok' => 'required|exists:tb_pemasok,id_pemasok',
            'jumlah_produk' => 'required|numeric|min:0',
        ]);

        $pembelian = Pembelian::create($request->all());

        if ($pembelian) {
            Session::flash('status', 'success');
            Session::flash('message', 'data berhasil ditambahkan');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Pembelian $pembelian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        //
        $pembelian = Pembelian::findOrFail($id);
        $pemasok = Pemasok::all()->where('id_pemasok', '!=', $pembelian->id_pemasok);
        return view('pembelian.edit', [
            'pembelian' => $pembelian,
            'pemasok' => $pemasok
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'tgl_pembelian' => 'required|date',
            'id_pemasok' => 'required|exists:tb_pemasok,id_pemasok',
            'jumlah_produk' => 'required|numeric|min:0'
        ]);
        
        $pembelian = Pembelian::findOrFail($id);
        $pembelian->update($request->all());

        if ($pembelian) {
            Session::flash('status', 'success');
            Session::flash('message', 'data berhasil diubah');
        }
        return redirect('/pembelian');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $pembelian = Pembelian::findOrFail($id);
        try {
            $pembelian->delete();
            Session::flash('status', 'success');
            Session::flash('message', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Gagal menghapus data: data ini sedang dipakai di tabel lain');
            return redirect('/pembelian');
        }
        return redirect('/pembelian');
    }
}
