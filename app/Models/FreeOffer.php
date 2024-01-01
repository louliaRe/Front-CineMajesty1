<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreeOffer extends Model
{
    protected $table='free_offers';
    protected $primaryKey='FO_id';
    
    public function Snack(){

        return $this->BelongsTo(Snack::class,'S_id','S_id');
    }
   

     protected $fillable=['start_date','expire_date','amount','req_amount','free_offer','S_id','free_snack'];
    

}
