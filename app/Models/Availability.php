<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    protected $table = 'availabilities';

    protected $fillable = [
        'washer_id',
        'day_of_week',
        'start_time',
        'end_time',
    ];

    // ---------------------- Relations ----------------------

    public function washer()
    {
        return $this->belongsTo(UserAccount::class, 'washer_id');
    }
}
