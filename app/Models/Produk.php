<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'tb_produk';
    protected $primaryKey = 'id_produk';
    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'harga',
        'id_perusahaan'
    ];
    public $timestamps = false;
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }
}
