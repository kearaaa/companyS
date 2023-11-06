<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $pelanggan = Pelanggan::all();
        return view('pelanggan.pelanggan', ['pelanggan' => $pelanggan]);
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
            'nama_pelanggan' => 'required|string|unique:tb_pelanggan,nama_pelanggan,except,id_pelanggan',
            'alamat' => 'required|string',
            'email' => 'required|email|unique:tb_pelanggan,email,except,id_pelanggan',
        ]);

        $pelanggan = Pelanggan::create($request->all());

        if ($pelanggan) {
            Session::flash('status', 'success');
            Session::flash('message', 'data berhasil ditambahkan');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Pelanggan $pelanggan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        //
        $pelanggan = Pelanggan::findOrFail($id);
        return view('pelanggan.edit', [
            'pelanggan' => $pelanggan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'nama_pelanggan' => 'required|string',
            'alamat' => 'required|string',
            'email' => 'required|email',
        ]);
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update($request->all());

        if ($pelanggan) {
            Session::flash('status', 'success');
            Session::flash('message', 'data berhasil diubah');
        }
        return redirect('/pelanggan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $pelanggan = Pelanggan::findOrFail($id);
        try {
            $pelanggan->delete();
            Session::flash('status', 'success');
            Session::flash('message', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Gagal menghapus data: data ini sedang dipakai di tabel lain');
            return redirect('/pelanggan');
        }
        return redirect('/pelanggan');
    }
}
