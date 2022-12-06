<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phrase extends Model
{
    use HasFactory;

    public function position()
    {
        return $this->hasOne(PhrasePosition::class, 'phrase_id', 'id')
            ->whereDate('created_at', date('Y-m-d'));
    }
}
