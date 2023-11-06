<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    protected $table = 'tb_karyawan';
    protected $primaryKey = 'id_karyawan';
    protected $fillable = [
        'nama_karyawan',
        'alamat',
        'email',
        'id_perusahaan',
    ];
    public $timestamps = false;
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }
}
