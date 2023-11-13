<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Pemasok;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $penjualan = Penjualan::with('pelanggan', 'produk', 'pembelian')->get();
        $pelanggan = Pelanggan::all();
        $produk = Produk::all();
        $pembelian = Pembelian::all();
        $pemasok = Pemasok::all();
        return view('penjualan.penjualan', [
            'penjualan' => $penjualan,
            'pelanggan' => $pelanggan,
            'produk' => $produk,
            'pemasok' => $pemasok,
            'pembelian' => $pembelian
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
        // $validated = $request->validate([
        //     'nama_penjualan' => 'unique:tb_penjualan',
        //     'email' => 'unique:tb_penjualan',
        // ]);

        $request->validate([
            'tgl_penjualan' => 'required|date',
            'id_pelanggan' => 'required|exists:tb_pelanggan,id_pelanggan',
            'id_produk' => 'required|exists:tb_produk,id_produk',
            'id_pembelian' => 'required|exists:tb_pembelian,id_pembelian',
            'jumlah_produk' => [
                'required',
                'numeric',
                'min:1',
                function ($attribute, $value, $fail) {
                    $tglpembelian = request('id_pembelian');
                    // Cek apakah ada pembelian yang sesuai
                    $matchingPembelian = Pembelian::where([
                        'id_pembelian' => $tglpembelian,
                    ])->first();

                    if ($matchingPembelian) {
                        $jumlahProdukPembelian = $matchingPembelian->jumlah_produk;

                        if ($value > $jumlahProdukPembelian) {
                            $fail('Jumlah produk melebihi jumlah yang tersedia (' . $jumlahProdukPembelian . ').');
                        }
                    } else {
                        $fail('Tidak ada pembelian yang sesuai pada tanggal ini.');
                    }
                },
            ],
        ]);

        $id_pembelian = $request->input('id_pembelian');
        $jumlah_produk_dijual = $request->input('jumlah_produk');

        $pembelian = Pembelian::find($id_pembelian);

        if ($pembelian) {
            if ($pembelian->jumlah_produk >= $jumlah_produk_dijual) {
                // Kurangkan jumlah produk yang digunakan
                $pembelian->jumlah_produk -= $jumlah_produk_dijual;
                $pembelian->save();
            } else {
                echo 'produk telah habis';
                // Tidak cukup produk yang tersedia
                // Handle pesan kesalahan atau tindakan lain sesuai kebutuhan
            }
        } else {
            // Penanganan jika id_pembelian tidak ditemukan
            echo 'tidak dapat menemukan id_pembelian';
        }

        $penjualan = Penjualan::create($request->all());

        if ($penjualan) {
            Session::flash('status', 'success');
            Session::flash('message', 'data berhasil ditambahkan');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Penjualan $penjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        //
        $penjualan = Penjualan::findOrFail($id);
        $pelanggan = Pelanggan::all();
        $produk = Produk::all();
        $pembelian = Pembelian::all();
        $pemasok = Pemasok::all();
        return view('penjualan.edit', [
            'penjualan' => $penjualan,
            'pelanggan' => $pelanggan,
            'pembelian' => $pembelian,
            'pemasok' => $pemasok,
            'produk' => $produk
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tgl_penjualan' => 'required|date',
            'id_pelanggan' => 'required|exists:tb_pelanggan,id_pelanggan',
            'id_produk' => 'required|exists:tb_produk,id_produk',
            'id_pembelian' => 'required|exists:tb_pembelian,id_pembelian',
            'jumlah_produk' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($id, $request) {
                    $tglpembelian = $request->input('id_pembelian');
                    // Cek apakah ada pembelian yang sesuai
                    $matchingPembelian = Pembelian::where([
                        'id_pembelian' => $tglpembelian,
                    ])->first();

                    if ($matchingPembelian) {
                        $jumlahProdukPembelian = $matchingPembelian->jumlah_produk;

                        $penjualan = Penjualan::findOrFail($id);

                        if ($penjualan) {
                            // Simpan jumlah produk awal sebelum perubahan
                            $previousJumlahProduk = $penjualan->jumlah_produk;

                            if ($value > $jumlahProdukPembelian) {
                                $fail('Jumlah produk melebihi jumlah yang tersedia (Maksimum: ' . $jumlahProdukPembelian . ').');
                            } else {
                                // Mengembalikan sisa produk ke pembelian
                                if ($value < $previousJumlahProduk) {
                                    $sisaProduk = $previousJumlahProduk - $value;
                                    $pembelian = Pembelian::find($tglpembelian);
                                    $pembelian->jumlah_produk += $sisaProduk;
                                    $pembelian->save();
                                }

                                // Update jumlah produk pada tb_penjualan
                                $penjualan->update($request->all());
                            }
                        }
                    } else {
                        $fail('Tidak ada pembelian yang sesuai pada tanggal ini.');
                    }
                },
            ]
        ]);

        $penjualan = Penjualan::findOrFail($id);
        $penjualan->update($request->all());

        if ($penjualan) {
            Session::flash('status', 'success');
            Session::flash('message', 'data berhasil diubah');
        }
        return redirect('/penjualan');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $penjualan = Penjualan::findOrFail($id);

        if (!$penjualan) {
            return redirect('/penjualan');
        }

        $jumlah_produk_dijual = $penjualan->jumlah_produk;
        $id_pembelian = $penjualan->id_pembelian;

        $pembelian = Pembelian::find($id_pembelian);

        if ($pembelian) {
            // Tambahkan kembali jumlah produk ke tb_pembelian
            $pembelian->jumlah_produk += $jumlah_produk_dijual;
            $pembelian->save();
        }

        try {
            $penjualan->delete();
            Session::flash('status', 'success');
            Session::flash('message', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            Session::flash('status', 'error');
            Session::flash('message', 'Gagal menghapus data: data ini sedang dipakai di tabel lain');
        }

        return redirect('/penjualan');
    }
}
