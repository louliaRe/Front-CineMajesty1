<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;
    protected $table='genres';
    protected $primaryKey='G_id';
    public function Films(){

        return $this->belongstomany(Film::class,'film_genres','G_id','F_id');
    }
}
