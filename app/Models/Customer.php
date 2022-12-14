<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public function phrases()
    {
        return $this->hasMany(Phrase::class, 'customer_id', 'id');
    }
}
