<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $table='videos';
    protected $primaryKey='V_id';
    public function Film(){

        return $this->belongsTo(Film::class,'F_id','F_id');
    }
    protected $fillable=['video_path','url'];

}
