<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'category_id',
        'price', 
        'stock', 
        'image', 
        'description', 
        'compatibility_data'
    ];

    protected $casts = [
        'compatibility_data' => 'array',
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getDiscountPercentAttribute()
    {
        if (isset($this->attributes['sale_price']) && $this->attributes['sale_price'] < $this->attributes['price']) {
            return round((($this->attributes['price'] - $this->attributes['sale_price']) / $this->attributes['price']) * 100);
        }
        
        return null;
    }

    public function getIsNewAttribute()
    {
        return $this->created_at->diffInDays(now()) < 7;
    }
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }
    
    // Count reviews
    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }
}

