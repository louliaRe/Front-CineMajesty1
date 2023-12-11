<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PublicOffer;
use App\Models\PrivateOffer;
use App\Models\Booking;
use App\Models\ShowTime;
use App\Models\Snack;
use App\Models\Customer;
use App\Models\Ticket;
use Carbon\Carbon;

class OfferController extends Controller
{
    public function index(){
  
        $customers = Customer::join('bookings', 'customers.C_id', '=', 'bookings.C_id')
        ->select('customers.C_id')
        ->groupBy('customers.C_id')
        ->havingRaw('COUNT(bookings.B_id) % 10 = 0')
        ->get();

        $snacks=Snack::all();
        $current=date('Y-m-d');
        $showtimes=ShowTime::join('shows','shows.SH_id','=','show_times.SH_id')->where('shows.start_date','>',$current)->get();

        return view ('offer.index',compact('customers','snacks','showtimes'));

    }
    public function create(){
        $snacks=Snack::all();

        return view('offer.create',compact('snacks'));
    }

    public function store(Request $request){
        // dd($request->all());
        $data = $request->validate([
            'amount' => 'required|numeric',
            'start_date' => 'required|date',
            'expire_date' => 'required|date|after:start_date',
                      
        ]);
$type=$request->input('type');
$snacks=$request->input('S_id',[]);
$start=$request->input('start_date');
$expire=$request->input('expire_date');

    

        if ($type==='snack'){
            foreach($snacks as $snack){
              
                $ID=Snack::find($snack);
                $check=$ID->PublicOffers()->where('expire_date','>=',$start)->first();
                if ($check){
 
                    return redirect('/employee/offers/create');
 
                }
                else{

                    $offer=PublicOffer::create([
                      
                        'start_date'=>$start,
                        'expire_date'=>$expire,
                        'amount'=>$data['amount']

                    ]);
                   $offer->snacks()->attach($snack);
                    return redirect('/employee/offers');
                }
            }         
        }
        elseif ($type==='showtime') {
            $id=$request->input('SHT_id');
            $find=ShowTime::find($id);
            if ($find){

                $offer=PublicOffer::create([
                    
                        'start_date'=>$start,
                        'expire_date'=>$expire,
                        'amount'=>$data['amount']
                ]);
                
                $find->PU_id = $offer->PU_id;
                $find->save();
            
                return redirect('/employee/offers');


            }           
            else{
                return redirect('/employee/offers/create');

            }
        }
            

    }
}
