<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // FIX: Memastikan nama kolom 'estimated_completion_date' terdaftar di sini
    protected $fillable = [
        'name',
        'price_per_kg',
        'estimated_completion_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // FIX: Memastikan Laravel memperlakukan kolom ini sebagai objek Tanggal
    protected $casts = [
        'estimated_completion_date' => 'date',
    ];
}

