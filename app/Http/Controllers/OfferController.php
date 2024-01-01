<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PublicOffer;
use App\Models\FreeOffer;
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
    public function create_show_offer($SHT_id){
      

        return view('offer.show',compact('SHT_id'));
    }
    public function create_snack_offer($S_id){
       $snacks=Snack::all();
        return view('offer.snack',compact('S_id','snacks'));
    }
    public function create_snack_offer_discount(){

        $snacks=Snack::all();
        return view('offer.discount',compact('snacks'));
    }

    public function store_snack(Request $request,$S_id){
      
$ID=Snack::find($S_id);
$start=$request->input('start_date');
$expire=$request->input('expire_date');

    $check=$ID->FreeOffer()->where('expire_date','>=',$start)->first();
    
      
        $check=$ID->FreeOffer()->where('expire_date','>=',$start)->first();
      
       
        if (!$check &&  $start
        && $expire && $request->input('req_num') && $request->input('free_offer')&& $request->input('free_snack') && $start < $expire ){

        $free_offer=FreeOffer::create([
                  'S_id'=>$S_id,
                'start_date'=>$start,
                'expire_date'=>$expire,
                'req_amount'=>$request->input('req_num'),
                'free_offer'=>$request->input('free_offer'),
                'free_snack'=>$request->input('free_snack'),
                

            ]);
           
          
            return redirect('/employee/offers');


        }           
        else{
            return redirect('/employee/offers');

        }
    
   
}

    
    public function store_show(Request $request,$SHT_id){
   // dd($request->input());
   //dd($SHT_id);
 $type=$request->input('type');

// dd($expire);
$ID=ShowTime::find($SHT_id);

    
            $start=$request->input('D_start_date');
            $expire=$request->input('D_expire_date');
         
                $check=$ID->PublicOffer()->where('expire_date','>=',$start)->first();
                if (!$check && $request->input('D_amount') && $start
                && $expire && $start < $expire){
                 $PU= PublicOffer::create([ 
                        'start_date'=>$start,
                        'expire_date'=>$expire,
                        'amount'=>$request->input('D_amount'),
                        
                    ]);
                    $PU->Showtime()->Save($ID);
                    return redirect('/employee/offers');
                }
                else{                
                    return redirect('/employee/offers/create');
                }                  
        
    
        
    }
    public function store_snack_discount(request $request){

        
$start=$request->input('start_date');
$expire=$request->input('expire_date');
$snacks=$request->input('S_id');
    

      
            foreach($snacks as $snack){
              
                $ID=Snack::find($snack);
                $check=PublicOffer::join('offer_snack','offer_snack.PU_id','=','public_offers.PU_id')
                ->join('snacks','snacks.S_id','=','offer_snack.S_id')
                ->where('public_offers.expire_date','<',$start)
                ->first();
                if ($check){
 
                    return redirect('/employee/offers/create');
 
                }
                elseif(!$check && $request->input('amount') && $start
                && $expire && $start < $expire){

                    $offer=PublicOffer::create([
                      
                        'start_date'=>$start,
                        'expire_date'=>$expire,
                        'amount'=>$request->input('amount'),
                    ]);
                   $offer->snacks()->attach($snack);
                    return redirect('/employee/offers');
                }
                else{
                    return redirect('/employee/offers');
                }
            
         
        }
            

    }
}
