<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditHistory extends Model
{
    use HasFactory;

    public function user_info()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
