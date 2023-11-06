<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;
    protected $table = 'tb_perusahaan';
    protected $primaryKey = 'id_perusahaan';
    protected $fillable = [
        'nama_perusahaan',
        'alamat',
        'email'
    ];
    public $timestamps = false;
}
