<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeInListing extends Model
{
    use HasFactory;

    protected $table = 'trade_in_listings';

    protected $fillable = [
        'user_id',
        'component_details',
        'condition',
        'pricing',
    ];


    /**
     * Get the user who created the trade-in listing.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
