<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'phone_number', 'profile', 'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Service bookings made by the user (customer).
     */
    public function serviceBookings()
    {
        return $this->hasMany(ServiceBooking::class);
    }

    /**
     * Service bookings assigned to the user as a technician.
     */
    public function assignedBookings()
    {
        return $this->hasMany(ServiceBooking::class, 'technician_id');
    }

    public function pcBuilds()
    {
        return $this->hasMany(PcBuildConfiguration::class, 'user_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function tradeIns()
    {
        return $this->hasMany(TradeInListing::class);
    }

    public function techConsultationRequests()
    {
        return $this->hasMany(TechConsultationRequest::class);
    }
}
