<?php

namespace App\Http\Controllers;
use App\Models\Seat;
use App\Models\Snack;
use App\Models\Booking;
use App\Models\Hall;
use App\Models\Showtime;
use App\Models\SeatShowtime ;
use App\Models\Customer ;
use App\Models\Ticket ;
use App\Models\PublicOffer ;
use App\Models\PrivateOffer ;
use App\Models\Wallet ;
use App\Mail\CustomerEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;


class BookingController extends Controller
{
  public function index(){
    $email=auth()->user()->email;
    $C_id=Customer::where('email',$email)->first()->C_id;
    $bookings = Booking::join('tickets', 'tickets.B_id', '=', 'bookings.B_id')
    ->join('seat_showtime', 'seat_showtime.SS_id', '=', 'tickets.SS_id')
    ->join('hall_showtime', 'hall_showtime.HS_id', '=', 'seat_showtime.HS_id')
    ->join('show_times', 'show_times.SHT_id', '=', 'hall_showtime.SHT_id')
    ->join('shows', 'shows.SH_id', '=', 'show_times.SH_id')
    ->join('films', 'films.F_id', '=', 'shows.F_id')
    ->join('halls', 'halls.H_id', '=', 'hall_showtime.H_id')
    ->select('bookings.*', 'halls.*', 'show_times.*', 'shows.*', 'films.*')
    ->distinct('bookings.B_id')
    ->where('bookings.C_id', $C_id)
    ->get();
   
   
    return view('booking.index',compact('bookings'));

  }
  public function show($SHT_id,$H_id,$age)
    {
      
        $email = auth()->user()->email;
        $Customer = Customer::where('email', $email)->first();   
        $C_age=$Customer->age;
        $C_id=$Customer->C_id;
        $wallet=Wallet::where('C_id',$C_id)->first();
    
        if($C_age>=$age && $wallet){
          $seats=SeatShowtime::join('hall_showtime','hall_showtime.HS_id','=','seat_showtime.HS_id')
          ->join('seats','seats.SE_id','=','seat_showtime.SE_id')
          ->where('hall_showtime.SHT_id',$SHT_id)
          ->where('hall_showtime.H_id',$H_id)
          ->get();
          $snacks=Snack::orderBy('name')->get();
        return view('booking.show',compact('seats','snacks','SHT_id'));
        }
        else{
          return redirect('/')->with('error','wait a couple of years');
        }    
    }
  public function submitjob(request $request,$SHT_id){
    //  dd($request->input());
   
     $snack_total=0;
     $offer_amount=0;
     $private_offer_amount=0;
     

     $snacks=$request->input('qty');
     
      // $snack_total=$snack_total/100*;

 
      $seats = $request->input('SS_id');
      $show_offers=PublicOffer::join('show_times','show_times.PU_id','=','public_offers.PU_id')
      ->where('show_times.SHT_id',$SHT_id)
      ->first();
      if($show_offers){

        $show_amount=$show_offers->amount;
      
       
      }
      $currentDate = date('Y-m-d');
      $futureDate = date('Y-m-d', strtotime('+5 days', strtotime($currentDate)));
      $email = auth()->user()->email;
      $customer = Customer::where('email', $email)->first();
      $C_id=$customer->C_id;
      // $name=$customer->f_name. " ". $customer->l_name;
      $wallet=Wallet::where('C_id',$C_id)->first();
      $wallet_amount=$wallet->amount;
      $age=$customer->age;
    
     
     // dd($email);
     
      // Begin a database transaction
   
     
      
      DB::beginTransaction();
  
      try { 
          $b = Booking::create([
              'C_id' => $C_id,
              'total' => 0
          ]);
          $b->save();

          $bID=$b->B_id;

          foreach ($seats as $seat) {
              // Apply a lock on the seat record
              $ticket_price=hall::join('seats','seats.H_id','=','halls.H_id')
              ->join('seat_showtime','seat_Showtime.SE_id','=','seats.SE_id')
              ->where('seat_showtime.SS_id',$seat)->first()->price;
                        
              $seat = SeatShowtime::where('SS_id', $seat)->lockForUpdate()->first();
  
              if ($seat && $seat->status === 'available') {
                  // Process the booking
                  $seat->status = 'booked';
                  $seat->save();

                  $ticket=Ticket::create([
                    'B_id'=>$bID,
                    'SS_id'=>$seat->SS_id
                  ]); 
                  $ticket_total=0;
                  $ticket_total+=$ticket_price; 
                
                  $customer_tickets=Customer::where('C_id',$C_id)->first();
            
                  $tickets_num=$customer_tickets->tickets_num+1;  
                  $customer_tickets->update([
                    'tickets_num'=>$tickets_num
                  ]);
                  $customer_tickets->save();    
                 

                 
              
                  $customer_tickets=$tickets_num;
                  
                  // dd($customer_tickets);
                                                         
              
                   
                  if($tickets_num % 15==0){
                    $code=Str::random(6);
                    $offer=PrivateOffer::create([
                      'C_id'=>$C_id,
                      'is_used'=>false,
                      'start_date'=>$currentDate,
                      'expire_date'=>$futureDate,
                      'amount'=>10,
                      'code'=>$code
                    ]);
                    $offer->save();
                    $data=$offer->code;
                    $this->sendEmailToCustomer($C_id,$data);
                  }
                  
                 // $emailInstance = new CustomerEmail();            
                
           
              } else {
                  // Handle seat unavailability
                  throw new \Exception('Seat booking failed. The seat might be already booked.');
              }
          }
        $total=0;
        $snack_total=0;
       
          // Commit the transaction if everything is successful
         //check show offers
          if($show_offers){
          $show_offer_amount=$ticket_total/100*$show_amount;
          $ticket_total=$ticket_total-$show_offer_amount;
          }
          //check snack offers

          if($snacks){
          foreach($snacks as $id=>$qty){
         
            $snack_offers=PublicOffer::join('offer_snack','offer_snack.PU_id','=','public_offers.PU_id')
            ->join('snacks','snacks.S_id','=','offer_snack.S_id')->where('snacks.S_id',$id)
            ->first();
             $snack1=Snack::where('S_id',$id)->first();
             $qty1=$snack1->qty;
             $snack1->update(['qty'=>$qty1-$qty]);   
           
              $price=$snack1->price;          
             
             $price_qty=$price*$qty;
             $snack_total+=$price_qty;
           
          
           $snack1->bookings()->attach($bID,['Qty'=>$qty]);
             }
            
             $offer_total=0;
             if($snack_offers){
              $offer_amount=$snack_offers->amount;    
             $offer_total=$snack_total/100*$offer_amount;
             
             $snack_total-=$offer_total;
             }
           
            }
        //check the private offers
          if($request->input('code')){
            $check_private_offer=PrivateOffer::where('C_id',$C_id)->where('code',$request->input('code'))->first();   
            // dd($check_private_offer);
            if($check_private_offer){
           $private_offer_amount=$check_private_offer->amount;
        
              $final=$total/100*$private_offer_amount;
              $total=$total-$final;
           
              $check_private_offer->update(['code'=>"used"." ".$check_private_offer->PR_id,'is_used'=>1]);
              $check_private_offer->save();

            } 
            else{
            return redirect('/')->with('error','this code is already used');
            }
         
          }     
        
      
          $total=$ticket_total+$snack_total;
         
          if($wallet_amount >= $total)
          {

          $b->update(['total'=>$total]);
          $b->save();
          $wallet->update(['amount'=>$wallet_amount-$total]);
          $wallet->save();          
          DB::commit();
     
          return redirect('/')->with('success', 'Seats booked successfully!');
          } 
          else
          {
            DB::rollBack();
            return redirect('/')->with('error','u dont have enough');
          }
      } catch (\Exception $e) {
          // Rollback the transaction if an error occurs
          DB::rollBack();
  
          return redirect('/')->with('error', $e->getMessage());
      }
        }

  public function sendEmailToCustomer($id,$data)
    {
    $customer = Customer::find($id); // Replace with your customer retrieval logic
    Mail::to($customer->email)->send(new CustomerEmail($data));
     }
    
 public function delete ($B_id){
  
  $booking=Booking::where('bookings.B_id',$B_id)->first();

  $created_at=Carbon::parse($booking->created_at)->addHours(12);
  
  $snacks=Snack::join('book_snack','snacks.S_id','=','book_snack.S_id')
  ->join('bookings','bookings.B_id','=','book_snack.B_id')
  ->where('bookings.B_id',$B_id)->get();

  $current=Carbon::now();
  $email = auth()->user()->email;
  $Customer = Customer::where('email', $email)->first()->C_id;

  $wallet=Wallet::where('C_id',$Customer)->first();

  DB::beginTransaction();

  if($created_at>$current){

    if($snacks){
    foreach($snacks as $snack){
      $qty=$snack->Qty;
      $snack_qty=$snack->qty;
      $snack->qty= $snack_qty+$qty;
      $snack->save();
     
    }
  }
   
    $seats=SeatShowtime::join('tickets','seat_showtime.SS_id','=','tickets.SS_id')->join('bookings','tickets.B_id','=','bookings.B_id')
   ->where('bookings.B_id',$B_id)->select('seat_showtime.*')->get();

    foreach($seats as $seat){

      $seat->status = 'available';
      $seat->save();

    }
    $total=$booking->total/2;
   $amount=$wallet->amount;
  
    $wallet->update(['amount'=>$amount+$total]);
    $wallet->save();

    $booking->delete();
    

    DB::commit();
   return redirect('/')->with('success','booking is deleted');
  
  }
  else{
    DB::rollBack();
    return redirect('/')->with('error','you cant delete ur booking');
  }
  
}
public function edit($B_id,$SHT_id,$H_id){
    $seats=SeatShowtime::join('hall_showtime','hall_showtime.HS_id','=','seat_showtime.HS_id')
    ->join('show_times','show_times.SHT_id','=','hall_showtime.SHT_id')
    ->where('hall_showtime.SHT_id',$SHT_id)
    ->where('hall_showtime.H_id',$H_id)    
    ->get();
  $snacks=Snack::orderBy('name')->get();
  $booked_seats=SeatShowtime::join('tickets','tickets.SS_id','=','seat_showtime.SS_id')
  ->join('bookings','bookings.B_id','=','tickets.B_id')
  ->where('bookings.B_id',$B_id)
  ->get();
  $booked_snacks=Snack::join('book_snack','book_snack.S_id','=','snacks.S_id')
  ->join('bookings','bookings.B_id','=','book_snack.B_id')
  ->where('bookings.B_id',$B_id)
  ->get();
 
  return view ('booking.update',compact('seats','snacks','booked_snacks','booked_seats','B_id','H_id','SHT_id'));
}

   
public function update($B_id,$H_id,$SHT_id,Request $request){

 
 $booking_seats=SeatShowtime::join('tickets','tickets.SS_id','=','seat_showtime.SS_id')
->join('Bookings','Bookings.B_id','=','tickets.B_id')
->where('bookings.B_id',$B_id)
->get();

$booking_snacks=Snack::join('book_snack','book_snack.S_id','=','snacks.S_id')
->join('bookings','bookings.B_id','=','book_snack.B_id')
->where('bookings.B_id',$B_id)
->get();

$booking=Booking::where('B_id',$B_id)->first();

$created_at=Carbon::parse($booking->created_at)->addHours(24);
$current_date=Carbon::now();


$price=Hall::where('H_id',$H_id)->first()->price;


$email=auth()->user()->email;
$customer=Customer::where('email',$email)->first();
$wallet=Wallet::where('C_id',$customer->C_id)->first();

$new_booked_seats=$request->input('SS_id');
$new_booked_snacks=$request->input('qty');
if($created_at <= $current_date){
 DB::beginTransaction();
 //seats
 if($new_booked_seats && $new_booked_snacks){
  $updatedSeats = [];
  $old_seats=[];  

 foreach($new_booked_seats as $seat){
  $updatedSeats[] = $seat ;
 }

 foreach($booking_seats as $seat){
  
  $old_seats[] = strval($seat->SS_id);
 }
 $num_new_seats=count($updatedSeats);
 $seat_total=$num_new_seats * $price;
 $showtime_offers=PublicOffer::join('show_times','show_times.PU_id','=','public_offers.PU_id')->where('show_times.SHT_id',$SHT_id)->first();

 if($showtime_offers){
$seat_total=$seat_total/$showtime_offers->amount;
 }



 foreach($updatedSeats as $updatedSeat){
 
    $new_seat=SeatShowtime::where('SS_id',$updatedSeat)->first();
    if(!in_array($updatedSeat,$old_seats) && $new_seat->status == 'available'){
      $ticket=Ticket::create([
            'B_id'=>$B_id,
            'SS_id'=>$updatedSeat
          ]);
        
          $new_seat->update(['status'=>'booked']);
          $new_seat->save();    
  }
  
}

  foreach($booking_seats  as $booking_seat){
  
    if(!in_array($booking_seat->SS_id,$updatedSeats)){
      $old_seat=SeatShowtime::where('SS_id',$booking_seat->SS_id)->first();
      
      $old_seat->update(['status'=>'available']);
      $old_seat->save();
      Ticket::join('seat_showtime','seat_showtime.SS_id','=','tickets.SS_id')
      ->where('tickets.SS_id',$old_seat->SS_id)
      ->delete();
      
    }

  }
//snacks
  foreach($request->input('qty') as $key=>$value){
    $snack=Snack::find($key);
    
      foreach($booking_snacks as $booking_snack){
       $snack_price=$snack->price;
       $snack_total=$snack_price * $value;  
       if($value > $booking_snack->Qty)  {
        $new_Qty=$value-$booking_snack->Qty;
        $booking_snack->update(['qty'=>$booking_snack->qty - $new_Qty]);
        $booking_snack->save(); 

       }
       elseif($value < $booking_snack->Qty){
        $new_Qty=$booking_snack->Qty-$value;
        $booking_snack->update(['qty'=>$booking_snack->qty + $new_Qty]);
        $booking_snack->save(); 
       }
       
       $booking->Snacks()->updateExistingPivot($key,['Qty'=>$value]);  
     
      
    }
  

  }
 

  $snack_offer=PublicOffer::join('offer_snack','offer_snack.PU_id','=','public_offers.PU_id')
  ->join('snacks','snacks.S_id','=','offer_snack.S_id')
  ->where('offer_snack.S_id',$snack->S_id)
  ->where('public_offers.start_date','<=',$current_date)
  ->where('public_offers.expire_date','>=',$current_date)
  ->first();

  if($snack_offer){
   

    if($current_date < $snack_offer->expire_date && $current_date > $snack_offer->start_date){

      $snack_total=$snack_total/$snack_offer->amount;
      
    }
  }

  $new_total=$snack_total+$seat_total;
  if($booking->total > $new_total){

    $differance = $booking->total - $new_total;
    $wallet->update(['amount'=>$wallet->amount + $differance]);
    $wallet->save();
  }
  elseif($booking->total < $new_total){
    $differance =   $new_total - $booking->total;
    $wallet->update(['amount'=>$wallet->amount - $differance]);
    $wallet->save();
  }

  $booking->update(['total'=>$new_total]);
  $booking->save();  
  DB::commit();
}
else{
  DB::rollback();
  return redirect('/')->with('error','please choose carfully');
  
}

return redirect('/')->with('success','complete');
}
else{
  return redirect('/')->with('error','you r late');
  
}
  }
}