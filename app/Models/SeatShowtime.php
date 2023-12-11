<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeatShowtime  extends Model
{
    use HasFactory;

    
    protected $table='seat_showtime';
    protected $primaryKey='SS_id';

    public function Ticket(){
 
       return $this->belongsTo(Ticket::class,'SS_id','SS_id');

}

protected $fillable=['status'];

}
