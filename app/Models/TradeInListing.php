<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeInListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'component_details',
        'condition',
        'pricing',
        'status',
        'component_type',
        'brand',
        'image_path',
        'views',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
