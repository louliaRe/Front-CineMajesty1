<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hall_showtime extends Model
{
    protected $table='hall_showtime';
    protected $primaryKey='HS_id';
    public $timestamps = false;

    public function seats(){

        return $this->belongsToMany(Seat::class,'seat_showtime','HS_id','SE_id');
    }
    protected $fillable=['H_id'];


}
