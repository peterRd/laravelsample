<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\ReadingObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reading extends Model
{
    use HasFactory;

    public function instrument() {
        return $this->belongsTo('App\Instrument');
    }
}
