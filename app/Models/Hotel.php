<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    public function division(){
        return $this->belongsTo(Division::class);
    }
    public function district(){
        return $this->belongsTo(District::class);
    }
    public function subDistrict(){
        return $this->belongsTo(SubDistrict::class);
    }
    public function createdBy(){
        return $this->belongsTo(User::class,'created_by');
    }
}
