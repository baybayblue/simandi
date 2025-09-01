<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'invoice_code',
        'customer_id',
        'service_id',
        'user_id',
        'weight',
        'total_price',
        'status',
        'completion_date',
        'pickup_date',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'weight' => 'decimal:2',
        'completion_date' => 'datetime',
        'pickup_date' => 'datetime',
    ];

    /**
     * Mendapatkan data pelanggan yang terkait dengan transaksi.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Mendapatkan data layanan yang terkait dengan transaksi.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Mendapatkan data admin (user) yang memproses transaksi.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
