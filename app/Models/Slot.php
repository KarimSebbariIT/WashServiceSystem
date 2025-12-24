<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
   protected $fillable = [
        'start_datetime',
        'end_datetime',
        'slot_type_id',
    ];
}
