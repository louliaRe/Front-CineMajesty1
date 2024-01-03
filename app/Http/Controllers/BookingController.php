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
use App\Models\Film ;
use App\Models\PublicOffer ;
use App\Models\FreeOffer ;
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
    $bookings = Booking::join('seat_showtime', 'seat_showtime.B_id', '=', 'bookings.B_id')
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

      $ticket_price=hall::join('seats','seats.H_id','=','halls.H_id')
      ->join('seat_showtime','seat_Showtime.SE_id','=','seats.SE_id')
      ->join('hall_showtime','hall_showtime.HS_id','=','seat_showtime.HS_id')
      ->join('show_times','show_times.SHT_id','=','hall_showtime.SHT_id')
      ->where('show_times.SHT_id',$SHT_id)->first()->price;
    

      $currentDate = date('Y-m-d');
      $futureDate = date('Y-m-d', strtotime('+5 days', strtotime($currentDate)));
      $email = auth()->user()->email;
      $customer = Customer::where('email', $email)->first();
      $C_id=$customer->C_id;
      // $name=$customer->f_name. " ". $customer->l_name;
      $wallet=Wallet::where('C_id',$C_id)->first();
      $wallet_amount=$wallet->amount;
      $age=$customer->age;

     

    
     
      // Begin a database transaction
   
     if($seats){
      
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
              $seat = SeatShowtime::where('SS_id', $seat)->lockForUpdate()->first();
  
              if ($seat && $seat->status === 'available') {
                  // Process the booking
                  $seat->status = 'booked';
                  $seat->B_id = $b ->B_id; 
                  $seat->save();

               
                  $ticket_total=0;
                  $ticket_total+=$ticket_price; 
                
                  $customer_tickets=Customer::where('C_id',$C_id)->first();
            
                  $tickets_num=$customer_tickets->tickets_num+1;  
                  $customer_tickets->update([
                    'tickets_num'=>$tickets_num
                  ]);
                  $customer_tickets->save();    
                 

                  $customer_tickets=$tickets_num;
                  
                   
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
                 
             $snack_free_offers=FreeOffer::where('S_id',$id)
             ->where('start_date','<=',$currentDate)
             ->where('expire_date','>=',$currentDate)->first();
          

             $snack1=Snack::where('S_id',$id)->first();
             $qty1=$snack1->qty;
          
           
              $price=$snack1->price;          
             
             $price_qty=$price*$qty;
             $snack_total+=$price_qty;          
              $num=0;
        
             
            
          
             if($snack_free_offers){
              $free_snack= Snack::where('S_id',$snack_free_offers->free_snack)->first();
            //dd($snack_free_offers);
                
              if($qty >=  $snack_free_offers -> req_amount){
              //  dd($qty);
                $num = floor($qty /  $snack_free_offers -> req_amount) ;                 
              //dd($num);
              
              if($snack_free_offers->free_snack == $snack_free_offers->S_id ) {
           
                $qty_new= intval($snack_free_offers->free_offer * $num + $qty);

                $snack1->update(['qty'=>$snack1->qty - $qty_new]);  
                
                $snack1->bookings()->attach($bID,['Qty'=>$qty_new,  'book_snack'=>$qty]);         

              }
              elseif($snack_free_offers->free_snack != $snack_free_offers->S_id ){
                $qty_new=intval($snack_free_offers->free_offer * $num );
              

                if($snack_free_offers->S_id == $id ){                
                //  dd($snack_free_offers->free_snack);
              
           
                if($free_snack->bookings()->wherepivot('S_id',$free_snack->S_id) -> wherepivot('B_id',$bID) -> exists())  {
                  // $free_snack->update(['qty'=>$free_snack->qty - $qty_new]);
                  $old_qty=Snack::join('book_snack','book_snack.S_id','=','snacks.S_id')
                 ->join('bookings','bookings.B_id','=','book_snack.B_id')
                 ->where('book_snack.B_id',$bID)
                 ->where('book_snack.S_id',$free_snack->S_id)
                 ->first()->Qty;
                
               
                  $free_snack->bookings()->updateExistingPivot($bID , ['Qty'=>$old_qty+ $qty_new ,  'book_snack'=>$old_qty ]);
                  $free_snack->update(['qty'=>$free_snack->qty - $qty_new]);
                  $free_snack->save();
                  $snack1->bookings()->attach($bID,['Qty'=>$qty ]);
                  $snack1->update([ 'qty'=> $snack1->qty - $qty]);
                  $snack1->update();

                 
                }
                else{
                  
                    $free_snack->bookings()->attach($bID,['Qty'=>$qty_new ]);             
                    $free_snack->update(['qty'=>$free_snack->qty - $qty_new ]);
                      $free_snack->save();
                   $snack1->bookings()->attach($bID,['Qty'=>$qty]);
                   $snack1->update([ 'qty'=> $snack1->qty - $qty]);
                   $snack1->update();

                }
             
              }
              
              }
             }
             else{
              $snack1->update(['qty'=>$qty1-$qty]);   
              $snack1->bookings()->attach($bID,['Qty'=>$qty]);
             }
            }
            else{
            
              $snack1->update(['qty'=>$qty1-$qty]);
   
              if($snack1->bookings()->wherepivot('S_id',$id) -> wherepivot('B_id',$bID) -> exists())  {
           
                $mod_qty=Snack::join('book_snack','book_snack.S_id','=','snacks.S_id')
                ->join('bookings','bookings.B_id','=','book_snack.B_id')
                ->where('book_snack.B_id',$bID)            
                -> where('book_snack.S_id',$id)->first()->Qty;
                $snack1->bookings()->updateExistingPivot($bID , ['Qty'=>$mod_qty + $qty , 'book_snack'=>$qty]);

               
              }
              else{
           
                $snack1->bookings()->attach($bID,['Qty'=>$qty]);

              }


            }
          }
            $offer_total=0;
            if($snack_offers){
            
             $offer_amount=$snack_offers->amount;    
            $offer_total=$snack_total/100*$offer_amount;
            
            $snack_total-=$offer_total;
            }

       
            }
            //check free offers
        


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
    else{
      return redirect('/')->with('error','please book at least one seat');
    }
        }

  public function sendEmailToCustomer($id,$data)
    {
    $customer = Customer::find($id); // Replace with your customer retrieval logic
    Mail::to($customer->email)->send(new CustomerEmail($data));
     }
    
 public function delete ($B_id,$F_id){
  
  $film = Film::find($F_id);
  if($film->editable == 1){
  $booking=Booking::where('bookings.B_id',$B_id)->first();

  $created_at=Carbon::parse($booking->created_at)->addHours($film->time_allowed);
  
  $snacks=Snack::join('book_snack','snacks.S_id','=','book_snack.S_id')
  ->join('bookings','bookings.B_id','=','book_snack.B_id')
  ->where('bookings.B_id',$B_id)->get();

  $current=Carbon::now();
  $email = auth()->user()->email;
  $ct= Customer::where('email', $email)->first();
  $Customer = $ct ->C_id;

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
   
    $seats=SeatShowtime::join('bookings','seat_showtime.B_id','=','bookings.B_id')
   ->where('bookings.B_id',$B_id)->select('seat_showtime.*')->get();

    foreach($seats as $seat){

      $seat->status = 'available';
      $seat->save();

    }
    $total=$booking->total ;
    if($film->value_cut != null){
    $total=$booking->total * $film->value_cut/ 100 ;
    }
    
   $amount=$wallet->amount;
  
    $wallet->update(['amount'=>$amount+$total]);
    $wallet->save();

    $booking->delete();
    // dd($ct->tickets_num- count($seats));
    $ct->update(['tickets_num'=>$ct->tickets_num - count($seats)]);
    $ct->save();

    DB::commit();
   return redirect('/')->with('success','booking is deleted');
  
  }
  else{
    DB::rollBack();
    return redirect('/')->with('error','you cant delete ur booking');
  }
}
else{
  return redirect('/')->with('error','you cant delete ur booking');

}
  
}
public function edit($B_id,$SHT_id,$H_id,$F_id){
    $seats=SeatShowtime::join('hall_showtime','hall_showtime.HS_id','=','seat_showtime.HS_id')
    ->join('show_times','show_times.SHT_id','=','hall_showtime.SHT_id')
    ->where('hall_showtime.SHT_id',$SHT_id)
    ->where('hall_showtime.H_id',$H_id)    
    ->get();
  $snacks=Snack::orderBy('name')->get();
  $booked_seats=SeatShowtime::join('bookings','bookings.B_id','=','seat_showtime.B_id')
  ->where('bookings.B_id',$B_id)
  ->get();
  $booked_snacks=Snack::join('book_snack','book_snack.S_id','=','snacks.S_id')
  ->join('bookings','bookings.B_id','=','book_snack.B_id')
  ->where('bookings.B_id',$B_id)
  ->get();

  return view ('booking.update',compact('seats','snacks','booked_snacks','booked_seats','B_id','H_id','SHT_id','F_id'));
}

   
public function update($B_id,$H_id,$SHT_id,$F_id,Request $request){


 $film=Film::find($F_id);
//  dd($film);
 if($film->editable == 1){
 $booking_seats=SeatShowtime::join('Bookings','Bookings.B_id','=','seat_showtime.B_id')
->where('bookings.B_id',$B_id)
->get();

$booking_snacks=Snack::join('book_snack','book_snack.S_id','=','snacks.S_id')
->join('bookings','bookings.B_id','=','book_snack.B_id')
->where('bookings.B_id',$B_id)
->get();

$booking=Booking::where('B_id',$B_id)->first();

$created_at=Carbon::parse($booking->created_at)->addHours($film->time_allowed);
// dd($created_at);
$current_date=Carbon::now();
$created_at1=Carbon::parse($booking->created_at);


$price=Hall::where('H_id',$H_id)->first()->price;


$email=auth()->user()->email;
$customer=Customer::where('email',$email)->first();
$wallet=Wallet::where('C_id',$customer->C_id)->first();

$new_booked_seats=$request->input('SS_id');
$new_booked_snacks=$request->input('qty');
if($created_at1 <= $current_date &&  $current_date < $created_at ){
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
dd($customer);
 if($showtime_offers){
$seat_total=$seat_total/$showtime_offers->amount;
 }
if(count($old_seats) < $num_new_seats){
 
  $dif= $num_new_seats - count($old_seats) ;
  $customer->update(['tickets_num'=>$customer -> tickets_num + $dif]);
  $customer->save();

  if($customer->  tickets_num + $dif % 15==0){
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

}
else{
 
  $dif=count($old_seats) - $num_new_seats;
  $customer->update(['tickets_num'=>$customer -> tickets_num - $dif]);
  $customer->save();

}
// dd($dif);
 foreach($updatedSeats as $updatedSeat){
 
    $new_seat=SeatShowtime::where('SS_id',$updatedSeat)->first();
    if(!in_array($updatedSeat,$old_seats) && $new_seat->status == 'available'){
        
          $new_seat->update(['status'=>'booked','B_id'=>$B_id]);
          
          $new_seat->save();    
  }
  
}

  foreach($booking_seats  as $booking_seat){
  
    if(!in_array($booking_seat->SS_id,$updatedSeats)){
      $old_seat=SeatShowtime::where('SS_id',$booking_seat->SS_id)->first();
      
      $old_seat->update(['status'=>'available','B_id'=>null]);
      $old_seat->save();
     
    }

  }
}
else{
   DB::rollback();
  return redirect('/')->with('error','please choose carfully');
  
}
//snacks

$snack_total=0;
$d_price=0;
$a_price=0;
$num0=0;
$r=false;
$c=false;
$p=false;
$w=false;
  foreach($request->input('qty') as $key=>$value){
    $snack=Snack::find($key);

      foreach($booking_snacks as $booking_snack){
        
       $snack_price=$snack->price;
      //  
       $snack_free_offers=FreeOffer::where('S_id',$key)
       ->where('start_date','<=',$current_date)
       ->where('expire_date','>=',$current_date)->first();
   
      //checeking if there was a free offerings
    if($snack_free_offers){
    //  dd)
      $free_snack=Snack::join('book_snack','book_snack.S_id','=','snacks.S_id')
      ->join('bookings','bookings.B_id','=','book_snack.B_id')
     ->where('snacks.S_id',$snack_free_offers->free_snack)
     ->where('book_snack.B_id',$B_id)->first();
     // checking if the entered value is equal or more than the required amount for the offer 
      if($value >= $snack_free_offers -> req_amount){
       
        //checking if if the offer on the same snack 
        if($snack_free_offers->S_id == $snack_free_offers ->free_snack  && $booking_snack->S_id == $snack->S_id){
       
        //checking if the quantity entered is less than the old quantity
        if( $value < $booking_snack->Qty){
          // dd(2);
         //checing if the value entered is equals or more than the previous booked snacks
              if( $value >= $booking_snack -> book_snack ){
                dd(38);
                 $snack->bookings()->updateExistingPivot($B_id,['Qty'=>$value ]);     
                    $snack->update(['qty'=> $booking_snack->qty + $booking_snack-> Qty - $value]);
                    $snack->save();
          
              }
              //if the value entered is less than the previous booked snacks
              else{
            // ;
                  $d=$booking_snack-> book_snack - $value ; 
                  $d_price =$d_price+ $snack -> price * $d ;
                  $g=intval(floor($value / $snack_free_offers -> req_amount));
              

                  // dd($g );  

                  $snack->bookings()->updateExistingPivot($B_id,['Qty'=>$value + $g ,'book_snack'=>$value]);        
                  $snack->update(['qty'=> $booking_snack->qty + $booking_snack-> Qty - $value ]);     
                  $snack->save();
          
              }
            
              }
              //if the quantity entered is more than the old quantity
              elseif($value >  $booking_snack->Qty){
                
                $num4=0;
               $num=$value - $booking_snack->Qty ; // finding the number of new added snacks
               if($num > $snack->qty){
               $num1=$num + $booking_snack -> book_snack; // finding the number of booked snacks 
               $num2= $booking_snack -> book_snack  % $snack_free_offers->req_amount; //finding number of snacks that haven't been used in the offer
               $num3=$num2 + $num ; //the snacks that will be used in the new offer
               $check = intval(floor($num1 / $snack_free_offers->req_amount));
               $d_price=$d_price+$snack->price * $num; // price of the new added snacks

               //checking the number total snacks that will be used in the offer was more or equal to the required amount
           
                // dd(2);
              //  $num4=$num3 % $snack_free_offers->req_amount; //number of free snacks
               $snack->bookings()->updateExistingPivot($B_id,['book_snack'=>$value, 'Qty'=>$value + $num3]);        
               $snack->update(['qty'=>$booking_snack->qty - $value - $num3 ]);
               $snack->save();
          
              
               }
               else{
                DB::rollback();
                return redirect('/')->with('error','not enough snacks to add');
               }
              
              }
      }
      //if the offer not on the same snack
      elseif($snack_free_offers->S_id != $snack_free_offers ->free_snack && $booking_snack->S_id == $snack->S_id){
        
 //check if the current booked snack id equal to the free offer snack id and the free snack id equals to the snack that offer  will add to
      if($snack->S_id == $snack_free_offers->S_id && $free_snack->S_id == $snack_free_offers -> free_snack){
      //  dd(29);
          
      $Qty=Snack::join('book_snack','book_snack.S_id','=','snacks.S_id')
      ->where('book_snack.S_id',$key)
      ->where('book_snack.B_id',$B_id)
      ->first() ->Qty;
        $num0=intval(floor($value/$snack_free_offers->req_amount));//number of new offered free snacks 
        $num1=intval(floor($booking_snack->Qty/$snack_free_offers->req_amount)); // number of the old offered snacks
        // dd($num1);
        
        if($value < $booking_snack -> Qty ){//checking if the quantity entered for the snack is less than the old one
           $num=$booking_snack->Qty - $value; //diffrence between the qty's   
            //  dd($num0);   
           if($num0 < $num1){   //check if the number of the number of new offered free snacks is less than number of the old offered snacks
            //  dd(3);
            $num3=$num1 -$num0 ;
            $l=$free_snack->Qty - $num3;

            if($free_snack->book_snack == null){

              $num1=intval(floor($Qty / $snack_free_offers->req_amount));
              $s=$free_snack->Qty - $num1;
        
            //  dd(3);
              $free_snack->bookings()->updateExistingPivot($B_id,['Qty'=> $l ,'book_snack'=>$s ]);
              $free_snack->update([ 'qty' => $free_snack->qty + $num3 ]);
              $free_snack->save();
              $snack->bookings()->updateExistingPivot($B_id,['Qty'=> $value ]);
              $snack->update(['qty'=> $snack->qty + $num]);
              $snack->save();

              $p=true;

            }else{
          // dd(3);
            // dd(3);
              
            $free_snack->bookings()->updateExistingPivot($B_id,['Qty'=> $free_snack->Qty + $num3 ]);
            $free_snack->update([ 'qty' => $free_snack->qty + $num3 ]);
            $free_snack->save();
            $snack->bookings()->updateExistingPivot($B_id,['Qty'=> $value ]);
            $snack->update(['qty'=> $snack->qty + $num]);
            $snack->save();
     
            }
           }
           else{  //if the number of the number of new offered free snacks is equal to number of the old offered snacks
            //  dd($booking_snack);
       
                   
                if($w){
                  $free_snack->bookings()->updateExistingPivot($B_id,['Qty'=>$free_snack->Qty + $num0]);
                  $free_snack->update(['qty'=> $snack->qty - $num0]);
                  $free_snack->save();
                  $snack->bookings()->updateExistingPivot($B_id,['Qty'=> $value ]);
                  $snack->update(['qty'=> $snack->qty + $num]);
                  $snack->save();
                  $w=false;
                }
                else{
            $snack->bookings()->updateExistingPivot($B_id,['Qty'=> $value ]);
            $snack->update(['qty'=> $snack->qty + $num]);
            $snack->save();
                }
           }                    
        }
        //checking if the quantity entered for the snack is more than the old one
        elseif($value > $booking_snack -> Qty){
            // dd($num1);
          $num= $value - $booking_snack->Qty ; //diffrence between the qty's    
          if($num > $snack->qty){
          //  dd($num1);
         if($free_snack->book_snack == null){
       
          $num1=intval(floor($value / $snack_free_offers->req_amount));
       
         
          $free_snack->bookings()->updateExistingPivot($B_id, ['book_snack'=>$free_snack->Qty,'Qty'=>$free_snack->Qty + $num1]);
          $free_snack->update(['qty'=>$free_snack -> qty - $num1]);
          $free_snack->save();
          $snack->bookings()->updateExistingPivot($B_id, ['Qty'=>$value]);
          $snack->update(['qty'=> $snack->qty - $num]);
          $snack->save();       
          
        }
        else{
         
     //check if the number of the number of new offered free snacks is more than number of the old offered snacks
         if($num0 > $num1){
      
        
          $num3=$num0 - $num1 ;
       
          $x=$free_snack->Qty + $num3 ;//the number of the added free quantity to the free snack
          // dd($free_snack->Qty);
             dd($x);
          $free_snack->bookings()->updateExistingPivot($B_id,['Qty'=> $x ]);
          $free_snack->update([ 'qty' => $free_snack->qty - $num3 ]);
          $free_snack->save();
          $snack->bookings()->updateExistingPivot($B_id,['Qty'=> $value ]);
          $snack->update(['qty'=> $snack->qty - $num]);
          $snack->save();
          $c=true;
          
         }
         else{    //check if the number of the number of new offered free snacks is equal or less than number of the old offered snacks
          //  dd($value);
          if($w){
            $free_snack->bookings()->updateExistingPivot($B_id,['Qty'=>$free_snack->Qty + $num0]);
            $free_snack->update(['qty'=> $snack->qty - $num0]);
            $free_snack->save();
            $snack->bookings()->updateExistingPivot($B_id,['Qty'=> $value ]);
            $snack->update(['qty'=> $snack->qty + $num]);
            $snack->save();
            $w=false;
          }
          else{
            $snack->bookings()->updateExistingPivot($B_id,['Qty'=> $value ]);
            $snack->update(['qty'=> $snack->qty + $num]);
            $snack->save();
          }
         }
        }
      }
      else{
        DB::rollback();
        return redirect('/')->with('error','not enough snacks available');
      }
        }
  
      }

    }
 
} // if the amount entered is less than the required amount for the offer
 
else{
  //check if the value entered is more than the old value of the quantity
  if($value > $booking_snack->Qty && $booking_snack -> S_id == $snack->S_id)  {
     dd(204);
    $new_Qty=$value-$booking_snack->Qty;
    if($new_Qty > $snack->qty){
    // if($snack->S_id == $snack_free_offers -> free_snack){//check if the offer made for the same snack
      dd(204);
     $snack->bookings()->updateExistingPivot($B_id,['Qty'=>$value ]);  
     $snack->update(['qty'=>$booking_snack->qty - $new_Qty]);
     $snack->save();
     $d_price = $d_price + $new_Qty * $snack -> price;
   
    }
    else{
      DB::rollback();
      return redirect('/')->with('error','not enough snacks available');
    }
   
  }
   //check if the value entered is less than the old value of the quantity
  elseif($value < $booking_snack->Qty&& $booking_snack -> S_id == $snack->S_id){
// dd(2929);
    $new_Qty=$booking_snack->Qty-$value;
    $a_price=$a_price + $snack->price * $new_Qty;
    if($snack_free_offers->S_id== $snack_free_offers->free_snack){ //check type of the free offer
      $snack->bookings()->updateExistingPivot($B_id,['Qty'=>$value ,'book_snack'=>null]);
      $snack->update(['qty'=>$snack->qty + $new_Qty]);
      $snack->save();    

    }
    elseif($snack_free_offers->S_id != $snack_free_offers->free_snack){
      
      $new_Qty1=intval(floor($value / $snack_free_offers -> req_amount)); // finding the quantity of the old offer
      $free_snack->bookings()->updateExistingPivot($B_id,['Qty'=>$free_snack->Qty - $new_Qty1, 'book_snack'=>null]);
      $free_snack->update(['qty'=>$free_snack->qty + $new_Qty1]);
      $free_snack->save();
      $snack->bookings()->updateExistingPivot($B_id,['Qty'=>$value]);
      $snack->update(['qty'=>$snack->qty + $new_Qty]);
      $snack->save();
    
  }
}
    }
   }
    // if there was no free offerings
    else{
      
   if($booking_snack->S_id == $snack->S_id){
    $book_snack=snack::join('book_snack','book_snack.S_id','=','snacks.S_id')
    ->where('book_snack.S_id',$key)
    ->where('book_snack.B_id',$B_id)
    ->first()
    ->book_snack;

    if($value > $booking_snack ->Qty){
    //  dd(38);
      $new_Qty2=$value - $booking_snack->Qty ;
      if($new_Qty2 > $snack->qty){
      $d_price=$d_price + $snack->price * $new_Qty2;

      if($book_snack){        //checking if the snack was part of an offer
        if($c){
                    dd( $x  + $new_Qty2);
                   $snack->bookings()->updateExistingPivot($B_id,['Qty'=>$x + $new_Qty2 ,'book_snack'=>$value + $new_Qty2 ]);
                   $snack->update(['qty'=>$snack->qty - $new_Qty2]);
                   $snack->save();
                   $c=false;
             }
             elseif($r){
              // dd($num);
                 

                $snack->bookings()->updateExistingPivot($B_id,['Qty'=>$value + $num0 ,'book_snack'=>$value  ]);
                $snack->update(['qty'=>$snack->qty - $new_Qty2]);
                $snack->save();
                $r=false;

             }
        else{
            // dd($num0); 
        $snack->bookings()->updateExistingPivot($B_id,['Qty'=>$value + $num0 ,'book_snack'=>$value ]);
        $snack->update(['qty'=>$snack->qty - $new_Qty2]);
        $snack->save();
             }
      }
      else{  
        if($c){
        dd($value);
        $snack->bookings()->updateExistingPivot($B_id,['Qty'=>$x + $new_Qty2 ]);
        $snack->update(['qty'=>$snack->qty - $new_Qty2]);
        $snack->save();
        $c=false;
      }
     else{ 
      // dd($booking_snack->Qty + $new_Qty2);
     
      $snack->bookings()->updateExistingPivot($B_id,['Qty'=>$booking_snack->Qty + $new_Qty2 ]);
      $snack->update(['qty'=>$snack->qty - $new_Qty2]);
      $snack->save();
     }
      }
    }
    else{
      DB::rollback();
      return redirect('/')->with('error','not enough snacks available');
    }
    }
    elseif( $value < $booking_snack ->Qty){
      $new_Qty2=$booking_snack->Qty -$value ;
      $d_price=$d_price + $snack->price * $new_Qty2;
     
      if($book_snack){        //checking if the snack was part of an offer
        // dd($value);
        if($c){
              //  dd($value+ $num0);
          $snack->bookings()->updateExistingPivot($B_id,['Qty'=>$value+ $num0 ,'book_snack'=>$value ]);
        $snack->update(['qty'=>$snack->qty + $new_Qty2]);
        $snack->save();
        $c=false;
        }elseif($p){
         
            dd($booking_snack ->Qty- $booking_snack->book_snack);
         $snack->bookings()->updateExistingPivot($B_id,['Qty'=>$value + $num0 ,'book_snack'=>$value ]);
         $snack->update(['qty'=>$snack->qty + $new_Qty2]);
         $snack->save();
         $p=false;
       

        }
       else{
        //  dd($new_Qty2);
        if($book_snack- $new_Qty2 != 0){
              // dd($num0);
        $snack->bookings()->updateExistingPivot($B_id,['Qty'=>$value + $num0,'book_snack'=>$value ]);
        $snack->update(['qty'=>$snack->qty + $new_Qty2]);
        $snack->save();
        $w=true;
        }else{
            // dd($new_Qty2);
          $snack->bookings()->updateExistingPivot($B_id,['Qty'=> $value + $num0 ,'book_snack'=>null ]);
          $snack->update(['qty'=>$snack->qty + $new_Qty2]);
          $snack->save();
          $w=true;
        }
       }

       
      }
      else{
        // dd($value);
        if($c){
          dd($value);
          $snack->bookings()->updateExistingPivot($B_id,['Qty'=>$x - $new_Qty2 ]);
        $snack->update(['qty'=>$snack->qty + $new_Qty2]);
        $snack->save();
        $c=false;
        }
       else{
        $snack->bookings()->updateExistingPivot($B_id,['Qty'=>$booking_snack->Qty - $new_Qty2 ]);
        $snack->update(['qty'=>$snack->qty + $new_Qty2]);
        $snack->save();
        $w=true;
       }
      }
      
    }

  } 
  // dd(10220);
}
}
// dd($book_snack);
$book_snack_edit=snack::join('book_snack','book_snack.S_id','=','snacks.S_id')
->where('book_snack.S_id',$key)
->where('book_snack.B_id',$B_id)
->first()
->book_snack;
// dd($e);
if($book_snack_edit){
  $snack_total+=$snack_price * $book_snack_edit;  
  //  dd($snack_total);
}
else{
  $snack_total+=$snack_price * $value ;  
  //  dd($snack_total);
}

  }
  //  dd($snack_total);
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
  if($film->value_cut != null){

  $new_total=$snack_total+$seat_total ;
  $new_total=$new_total *  $film->value_cut / 100;
  }
else{
  $new_total=$snack_total+$seat_total ;

}
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
  return redirect('/')->with('error','you r late');
  
}
return redirect('/')->with('success','complete');

}
else{
  return redirct('/')->with('error','u cant update your booking');
}
}

  }
