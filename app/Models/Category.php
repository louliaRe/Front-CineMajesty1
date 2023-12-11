<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table='categories';
    protected $primaryKey='CAT_id';
    protected $fillable=['name'];
    public function Snacks(){

        return $this->hasMany(Snack::class,'CAT_id','CAT_id');
    }
}
