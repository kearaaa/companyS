<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    protected $table = 'tb_pembelian';
    protected $primaryKey = 'id_pembelian';
    protected $fillable = [
        'tgl_pembelian',
        'id_pemasok',
        'jumlah_produk'
    ];
    public $timestamps = false;
    public function pemasok()
    {
        return $this->belongsTo(Pemasok::class, 'id_pemasok', 'id_pemasok');
    }
}
