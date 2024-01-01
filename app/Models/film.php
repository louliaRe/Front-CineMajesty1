<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{

    use HasFactory;
    protected $table='films';
    protected $primaryKey='F_id';
    public function Casts(){

        return $this->belongstomany(Cast::class,'Cast_Film','F_id','CA_id');
    }
    public function Genres(){

        return $this->belongstomany(Genre::class,'film_genre','F_id','G_id');
    }
    
    public function Rates(){

        return $this->belongstomany(Rate::class,'rates','F_id','C_id');
    }

    public function Comments(){

        return $this->belongstomany(Comment::class,'comments','F_id','C_id');
    }

    public function Shows(){

        return $this->hasMany(Show::class,'F_id','F_id');
    }

    public function ScopeByGenre($query,$genre){

        return $query->join('film_genre','film_genre.F_id','=','films.F_id')
        ->join('genres','genres.G_id','=','film_genre.G_id')
        ->where('genres.name',$genre);
    }
    public function Videos(){

        return $this->hasMany(Video::class,'F_id','F_id');
    }
    public function Images(){

        return $this->hasMany(Image::class,'F_id','F_id');
    }

    protected $fillable=['name','description','age_req','duration','release_date','editable','time_allowed','value_cut'];
}
