<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ticket extends Model
{
    use HasFactory;

    protected $table='tickets';
    protected $primaryKey='T_id';
    protected $fillable=['B_id','SS_id'];

    public function Booking(){
 
       return $this->belongsTo(Booking::class,'B_id','B_id');

}
public function SeatShowtime (){


    return $this->hasOne(SeatShowtime ::class,'SS_id','SS_id');
}
}
