<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;
    
    protected $table='seats';
    protected $primaryKey='SE_id';

    protected $fillable=['seat_row','seat_num','seat_col','H_id'];
    public function Hall(){

        return $this->belongsto(hall::class,'H_id','H_id');
    }
    public function hallshow()
{
    return $this->belongsToMany(hall_showtime::class, 'seat_showtime', 'SE_id', 'HS_id');
}
    public function Ticket(){

        return $this->belongsto(ticket::class,'T_id','T_id');
    }
    
}
