<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    
    protected $table='employees';
    protected $primaryKey='E_id';
    protected $fillable=['f_name','l_name','email','password'];
    public function Role(){

        return $this->belongsto(Role::class,'R_id','R_id');
    }
    public function ScopeByPerson($query,$person)
    {
        return $query->where('f_name', 'like', '%' . $person . '%')
        ->orWhere('l_name', 'like', '%' . $person . '%')
        ->orWhereRaw("CONCAT(f_name, ' ', l_name) LIKE ?", ['%' . $person . '%']);
    }
 
}
