<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Washer extends Model
{
    protected $fillable = [
        'full_name',
        'region_id',
        'phone_number',
         'email'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
