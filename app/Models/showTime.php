<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowTime extends Model
{
    
    protected $table='show_times';
    protected $primaryKey='SHT_id';
    use HasFactory;
    protected $fillable=['start_time','H_id','end_time','PU_id'];
    public function Show(){

        return $this->belongsto(Show::class,'SH_id','SH_id');
    }
    public function Halls(){

        return $this->belongsToMany(Showtime::class,'hall_showtime','SHT_id','H_id');
    }

  
    public function PublicOffer(){

        return $this->belongsto(PublicOffer::class,'PU_id','PU_id');
    }
    public function Bookings(){

        return $this->hasMany(Booking::class,'SHT_id','SHT_id');
    }
}
