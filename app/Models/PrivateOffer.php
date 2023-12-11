<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateOffer extends Model
{
    use HasFactory;
    protected $table='private_offers';
    protected $primaryKey='PR_id';
    public function Customer(){

        return $this->belongsTo(Customer::class,'C_id','C_id');
     }
     protected $casts=['is_used'=>'boolean'];
     
    protected $fillable=['start_date','expire_date','amount','is_used','code','C_id'];
}
