<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggans'; // Pastikan nama tabel benar, yaitu 'pelanggans'

    protected $fillable = [
        'nama',
        'alamat',
        'nomor_telpon',
        'status',
    ];
}