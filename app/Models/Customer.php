<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// 1. Tambahkan baris ini untuk memanggil Trait
use App\Traits\LogsActivity;

class Customer extends Model
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
        'email',
        'phone',
        'address',
    ];
}

