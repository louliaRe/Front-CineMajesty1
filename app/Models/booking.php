<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    
    protected $table='bookings';
    protected $primaryKey='B_id';
    public function Tickets(){

        return $this->hasMany(Ticket::class,'T_id','T_id');
    }
    public function Customer(){

        return $this->belongsto(Customer::class,'C_id','C_id');
    }
    public function Snacks(){

        return $this->belongstomany(Snack::class,'Book_Snack','B_id','S_id')->withtimestamp()->withpivot('Qty');
    }
    public function BookingQueue(){
        return $this->HasMany(BookingQueue::class,'B_id','B_id');
    }
    
protected $fillable=['C_id','total'];
    
    
}
