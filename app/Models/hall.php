<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    use HasFactory;
    
    protected $table='halls';
    protected $primaryKey='H_id';
    public function Showtimes(){

        return $this->belongsToMany(Showtime::class,'hall_showtime','H_id','SHT_id');
    }
    public function Seats(){

        return $this->hasMany(Seat::class,'H_id','H_id');
    }
    public function type(){
        return $this->belongsTo(Type::class,'TY_id','TY_id');
    }
    protected $fillable=['total_seats','TY_id','status','price'];
}
