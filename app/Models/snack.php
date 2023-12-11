<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Snack extends Model
{
    use HasFactory;
    
    protected $table='snacks';
    protected $primaryKey='S_id';
    protected $fillable=['name','price','limit','qty'];
    public function PublicOffers(){

        return $this->belongsToMany(PublicOffer::class,'offer_snack','S_id','PU_id');
    }
   

    public function Bookings(){

        return $this->belongstomany(Booking::class,'Book_Snack','S_id','B_id');
    }
    public function Images(){

        return $this->hasMany(Image::class,'S_id','S_id');
    }
    
    public function Category(){

        return $this->Belongsto(Category::class,'CAT_id','CAT_id');
    }
}
