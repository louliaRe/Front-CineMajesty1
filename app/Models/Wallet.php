<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    
    protected $table='_e_wallets';
    protected $primaryKey='EW_id';
    public function Customer(){

        return $this->belongsTo(Customer::class,'C_id','C_id');
    }
     protected $fillable=['C_id','amount','address','PIN'];
}
