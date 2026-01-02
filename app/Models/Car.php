<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
  protected $fillable = ['name', 'model', 'car_type', 'user_id'];

   public function user()
    {
        return $this->belongsTo(UserAccount::class);
    }
}
