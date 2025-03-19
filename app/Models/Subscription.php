<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'subscriptions';
    
    protected $fillable = [
        'user_id',
        'subscription_type',
        'start_date',
        'end_date',
        'status',
    ];

      /**
     * Get the user who owns the subscription.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the subscription is active.
     */
    public function isActive()
    {
        return $this->status === 'active';
    }
}
