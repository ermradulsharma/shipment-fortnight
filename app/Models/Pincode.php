<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pincode extends Model
{
    protected $fillable = [
        'pin','pre_paid','country_code','city','district','reverse_pickup','state_code','cod','sort_code'
    ];
    
    use HasFactory;
}
