<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{


    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}