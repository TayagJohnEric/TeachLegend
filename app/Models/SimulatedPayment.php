<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimulatedPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'order_id', 'payment_method', 'payment_status', 'transaction_reference'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

