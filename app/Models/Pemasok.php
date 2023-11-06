<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemasok extends Model
{
    use HasFactory;
    protected $table = 'tb_pemasok';
    protected $primaryKey = 'id_pemasok';
    protected $fillable = [
        'nama_pemasok',
        'alamat',
        'email',
        'id_produk'
    ];
    public $timestamps = false;
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
