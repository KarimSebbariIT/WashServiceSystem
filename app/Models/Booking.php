<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'washer_id',
        'region_id',
        'date',
        'time_start',
        'time_end',
        'type',
        'status',
        'note',
        'comment',
        'payment_method',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Relations
    public function client()
    {
        return $this->belongsTo(UserAccount::class, 'user_id');
    }

    public function washer()
    {
        return $this->belongsTo(UserAccount::class, 'washer_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }
}
