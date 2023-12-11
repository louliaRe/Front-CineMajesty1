<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cast extends Model
{
    use HasFactory;
    
    protected $table='casts';
    protected $primaryKey='CA_id';
    public function Films(){

        return $this->belongstomany(Film::class,'Cast_Film','CA_id','F_id');
    }
    public function ScopeByPerson($query,$person)
    {
        return $query->where('f_name', 'like', '%' . $person . '%')
        ->orWhere('l_name', 'like', '%' . $person . '%')
        ->orWhereRaw("CONCAT(f_name, ' ', l_name) LIKE ?", ['%' . $person . '%']);
    }
    protected $casts=['is_dir'=>'boolean','is_act'=>'boolean'];
    protected $fillable=['f_name','l_name','is_dir','is_act'];

}
