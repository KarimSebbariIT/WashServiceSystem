<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory; // Keep it, safe even if you don't use factories

    // Allow mass assignment
    protected $fillable = [
        'user_id',
        'washer_id',
        'region_id',
        'car_id', 
        'date',
        'time_start',
        'time_end',
        'type',
        'status',
        'note',
        'comment',
        'payment_method',
        'location',
    ];

    // Relations

    // The user who made the booking
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Alias for client relation (if you use UserAccount as client)
    public function client()
    {
        return $this->belongsTo(UserAccount::class, 'user_id');
    }

    // The washer assigned to this booking
    public function washer()
    {
        return $this->belongsTo(UserAccount::class, 'washer_id');
    }

    // The region where the booking occurs
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    // The car assigned to this booking
    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }
    
}
