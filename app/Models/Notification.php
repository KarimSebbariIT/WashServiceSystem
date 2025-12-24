<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'user_id',
        'message',
        'read_at',
    ];

    // ---------------------- Relations ----------------------

    public function user()
    {
        return $this->belongsTo(UserAccount::class, 'user_id');
    }
}
