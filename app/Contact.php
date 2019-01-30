<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    // mass assignable values
    protected $fillable = array('id', 'first_name', 'last_name', 'email','mobile_number','active');
}
