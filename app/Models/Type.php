<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
  
    protected $table='types';
    protected $primaryKey='TY_id';
    protected $fillable=['name'];
    public function halls(){
        return $this->hasMany(Hall::class,'TY_id','TY_id');
    }
}
