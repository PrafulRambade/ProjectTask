<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public function customercontact()
    {
        return $this->hasMany(CustomerContact::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
