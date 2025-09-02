<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// 1. Tambahkan baris ini untuk memanggil Trait
use App\Traits\LogsActivity;

class Service extends Model
{
    // 2. Tambahkan baris ini untuk menggunakan Trait
    use HasFactory, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'price_per_kg',
        'estimated_completion_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'estimated_completion_date' => 'datetime',
    ];
}

