<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerContact extends Model
{
     protected $guarded = [];

    public function countries()
    {
        return $this->belongsTo(Country::class,'country_id','id');
    }

    public function states()
    {
        return $this->belongsTo(State::class,'state_id','id');
    }

    public function users()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
