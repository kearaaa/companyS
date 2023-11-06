<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $perusahaan = Perusahaan::all();
        return view('perusahaan.perusahaan', ['perusahaan' => $perusahaan]);
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
            'nama_perusahaan' => 'required|string|unique:tb_perusahaan,nama_perusahaan,except,id_perusahaan',
            'alamat' => 'required|string',
            'email' => 'required|email|unique:tb_perusahaan,email,except,id_perusahaan',
        ]);

        $perusahaan = Perusahaan::create($request->all());

        if ($perusahaan) {
            Session::flash('status', 'success');
            Session::flash('message', 'data berhasil ditambahkan');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Perusahaan $perusahaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        //
        $perusahaan = Perusahaan::findOrFail($id);
        return view('perusahaan.edit', [
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
            'nama_perusahaan' => 'required|string',
            'alamat' => 'required|string',
            'email' => 'required|email',
        ]);
        $perusahaan = Perusahaan::findOrFail($id);
        $perusahaan->update($request->all());

        if ($perusahaan) {
            Session::flash('status', 'success');
            Session::flash('message', 'data berhasil diubah');
        }
        return redirect('/perusahaan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $perusahaan = Perusahaan::findOrFail($id);
        try {
            $perusahaan->delete();
            Session::flash('status', 'success');
            Session::flash('message', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Gagal menghapus data: data ini sedang dipakai di tabel lain');
            return redirect('/perusahaan');
        }
        return redirect('/perusahaan');
    }
}
