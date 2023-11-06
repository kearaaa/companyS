<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $karyawan = Karyawan::with('perusahaan')->get();
        $perusahaan = Perusahaan::all();
        return view('karyawan.karyawan', [
            'karyawan' => $karyawan,
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
            'nama_karyawan' => 'required|string|unique:tb_karyawan,nama_karyawan,except,id_karyawan',
            'alamat' => 'required|string',
            'email' => 'required|email|unique:tb_karyawan,email,except,id_karyawan',
            'id_perusahaan' => 'required|exists:tb_perusahaan,id_perusahaan'
        ]);

        $karyawan = Karyawan::create($request->all());

        if ($karyawan) {
            Session::flash('status', 'success');
            Session::flash('message', 'data berhasil ditambahkan');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        //
        $karyawan = Karyawan::findOrFail($id);
        $perusahaan = Perusahaan::all()->where('id_perusahaan', '!=', $karyawan->id_perusahaan);
        return view('karyawan.edit', [
            'karyawan' => $karyawan,
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
            'nama_karyawan' => 'required|string',
            'alamat' => 'required|string',
            'email' => 'required|email',
            'id_perusahaan' => 'required|exists:tb_perusahaan,id_perusahaan'
        ]);

        $karyawan = Karyawan::findOrFail($id);
        $karyawan->updated($request->all());

        if ($karyawan) {
            Session::flash('status', 'success');
            Session::flash('message', 'data berhasil diubah');
        }
        return redirect('/karyawan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $karyawan = Karyawan::findOrFail($id);
        try {
            $karyawan->delete();
            Session::flash('status', 'success');
            Session::flash('message', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Gagal menghapus data: data ini sedang dipakai di tabel lain');
            return redirect('/karyawan');
        }

        return redirect('/karyawan');
    }
}
