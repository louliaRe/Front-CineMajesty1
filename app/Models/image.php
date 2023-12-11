<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $table='images';
    protected $primaryKey='IM_id';
    public function Film(){

        return $this->belongsTo(Film::class,'F_id','F_id');
    }
    public function Snack(){

        return $this->belongsTo(Snack::class,'S_id','S_id');
    }

    protected $fillable=['image_path'];

}
