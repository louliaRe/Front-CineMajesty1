<?php

namespace App\Http\Controllers;
use App\Models\Film;
use App\Models\Customer;
use Illuminate\Http\Request;

class CommentController extends Controller
{
   
    public function store(request $request,$F_id){
        if(auth()->user()){
        if ($request->input()){
            $email = auth()->user()->email;
           
            $C_id = Customer::where('email', $email)->first()->C_id;
            $comment=$request->input('comment');
            $film=Film::find($F_id);
            if($C_id && $film){
                $film->Comments()->attach($C_id,['comments'=>$comment]);
                 return redirect('/');         
            }
        }
    }
        else{
            return redirect('login');
        }
    }
}
