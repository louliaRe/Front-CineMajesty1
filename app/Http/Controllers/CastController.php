<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cast;

class CastController extends Controller
{
  
  
    public function create(Request $request){
        $filmId = $request->route('id');
   
       
        $casts=Cast::orderBy('f_name')->get();
     
        return view('cast.create',compact('casts','filmId'));

    }
        public function store(request $request,$F_id){
      
     
            $filmId = $F_id;
           
           if($filmId){
if ($request->input('casts.0.f_name')&&$request->input('casts.0.l_name')&&$request->input('casts.0.type')){
    
    $casts=$request->input('casts');
    $Type = $request->input('type');
   
    foreach($casts as $cast){
 
$check=Cast::where('f_name',$cast['f_name'])->where('l_name',$cast['l_name'])->first();

    if(!$check){
        if ($cast['type']==='dir'){
            $cast=Cast::create([
                'f_name'=>$cast['f_name'],
                'l_name'=>$cast['l_name'],
            ]);
            $cast->save();
            $cast->films()->attach($filmId,[ 'is_dir'=>true,
            'is_act'=>false]);

        }
        elseif($cast['type']==='act'){
            $cast=Cast::create([
                'f_name'=>$cast['f_name'],
                'l_name'=>$cast['l_name'],
                
            ]);
            $cast->save();
            $cast->films()->attach($filmId,['is_dir'=>false,
            'is_act'=>true]);
        }
        elseif($cast['type']==='both'){{

            $cast=Cast::create([
                'f_name'=>$cast['f_name'],
                'l_name'=>$cast['l_name'],
               
            ]);
            $cast->save();
            $cast->films()->attach($filmId,['is_dir'=>true,
            'is_act'=>true]);
        }}
        // dd(print_r($cast));
     
    }
    else{
        return redirect()->route('employee.index')->with('error','such cast is already exiested');
    }
    }
    } 
            foreach ($request->input() as $inputName => $inputValue) {
        
                if (strpos($inputName, 'cat') !== false) {
                    $castId = str_replace('cat', '', $inputName);
                    $cast = Cast::find($castId);

                    if ($cast) {
                        
                        if($inputValue=='dir'){
                        $cast->films()->attach($filmId,['is_dir'=>true,'is_act'=>false]);
                        }
                        elseif($inputValue == 'act'){
                            $cast->films()->attach($filmId,['is_dir'=>false,'is_act'=>true]);
                        }
                        else{
                            $cast->films()->attach($filmId,['is_dir'=>true,'is_act'=>true]);
                        }

                    }
                }
            }
        
       
      
        return redirect()->route('employee.index')->with('success', 'Cast created successfully');
    }
        else{

            return redirect()->route('employee.index')->with('error','u cant create cast without film');
        }
        }
    }
    