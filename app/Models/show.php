<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    use HasFactory;
    protected $table='shows';
    protected $primaryKey='SH_id';
    protected $fillable=['start_date','end_date'];
    public function Showtimes(){

        return $this->hasMany(Showtime::class,'SH_id','SH_id');
    }
    public function Film(){

        return $this->belongsto(Film::class,'F_id','F_id');
    }
   
    public function Tickets(){

        return $this->hasMany(Ticket::class,'SH_id','SH_id');
    }
   
}
