<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Transaction extends Model
{
    use HasFactory, LogsActivity;

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
        'payment_status',
        'completion_date',
        'pickup_date',
        'notes',
    ];

    /**
     * Get the customer that owns the transaction.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the service for the transaction.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the user who processed the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

