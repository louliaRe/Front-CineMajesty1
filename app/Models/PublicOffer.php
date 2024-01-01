<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicOffer extends Model
{
    use HasFactory;
    
    protected $table='public_offers';
    protected $primaryKey='PU_id';
    public function Snacks(){

      return $this->belongsToMany(Snack::class,'offer_snack','PU_id','S_id');
  }

public function Showtime(){

   return $this->hasOne(Showtime::class,'PU_id','PU_id');
}
 
  
    
    protected $fillable=['start_date','expire_date','amount'];
    
}

