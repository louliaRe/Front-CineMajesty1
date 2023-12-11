<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;
use App\Models\Cast;
use App\Models\Employee;
use App\Models\Customer;



class SearchController extends Controller
{
    public function searchFilm(Request $request) {
        $name = $request->input('query');
        $searchType = $request->input('search_type');
    
        if ($searchType === 'films') {
            $results = Film::where('name', 'like', '%' . $name . '%')->get();
        } elseif ($searchType === 'casts') {
                       
            $results = Cast::ByPerson($name)->get();
        }
        else{
            return redirect('/');
        }
    
        return view('search.filmresaults', compact('results','searchType'));
    }
    public function searchEmp(Request $request){


        $name = $request->input('query');
        $results = Employee::ByPerson($name)->wherein('R_id',[2,3])->get();
        return view('search.empresults', ['results' => $results]);
       
    }

    public function searchcus(request $request){
        $name=$request->input('query');
        
$results=Customer::ByPerson($name)->join('_e_wallets','_e_wallets.C_id','=','customers.C_id')->get();

 return view('search.cusresults',compact('results'));
}
    
}
