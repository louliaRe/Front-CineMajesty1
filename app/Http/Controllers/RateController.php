<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use App\Models\Film;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function Rate(request $request){

        $email=auth()->user()->email;
        $customer=Customer::where('email',$email)->first();
     
           $value= $request->input('rate');
        
           $customer->update(['rate'=>$value]);
           $customer->save();
           return redirect('/')->with('success','thank you');     
        

    }
    public function RateFilm(Request $request,$F_id){
        $film=Film::find($F_id);
        $email=auth()->user()->email;
        $customer=Customer::where('email',$email)->first()->C_id;
     
        if($film){
            $film->Rates()->attach($customer,['value'=>$request->input('rate')]);
            return redirect('/')->with('thank you for rating the film');    
        }
    }
   
}
