<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    
    
    protected $table='roles';
    protected $primaryKey='R_id';

    public function Employees(){

        return $this->hasMany(Employee::class,'R_id','R_id');
    }
    public function Customers(){

        return $this->hasMany(Customer::class,'R_id','R_id');
    }
    public function Users(){

        return $this->hasMany(User::class,'R_id','R_id');
    }

    
  
    
}
