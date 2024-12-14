<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingStatusDetail extends Model
{
    use HasFactory;
    // 'RESERVED,BOOKED,AVAILABLE'
    static $RESERVED ='RESERVED';
    static $BOOKED ='BOOKED';
    static $AVAILABLE ='AVAILABLE';



}
