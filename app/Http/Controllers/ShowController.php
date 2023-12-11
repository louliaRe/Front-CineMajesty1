<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Show;
use App\Models\Film;
use App\Models\Hall;
use App\Models\ShowTime;
use App\Models\Seat;
use App\Models\hall_showtime;
use Carbon\Carbon;



class ShowController extends Controller
{
       public function index(){
    $current=carbon::now()->toDateString();
    $results=Film::join('shows','shows.F_id','=','films.F_id')->join('show_times','show_times.SH_id','=','shows.SH_id')
    ->join('hall_showtime','show_times.SHT_id','=','hall_showtime.SHT_id')->join('halls','halls.H_id','=','hall_showtime.H_id')
    ->where('shows.start_date','>=',$current)->get();
 
   return view('show.index',compact('results'));

    
}
    
    public function create()
    {
        $films = Film::with('shows.showtimes.halls')->get();
       
        $halls=Hall::all();
       
         $current=carbon::now()->toDateString();

         $results=Film::join('shows','shows.F_id','=','films.F_id')->join('show_times','show_times.SH_id','=','shows.SH_id')
         ->join('hall_showtime','show_times.SHT_id','=','hall_showtime.SHT_id')->join('halls','halls.H_id','=','hall_showtime.H_id')
         ->where('shows.start_date','>=',$current)->get();

       
    
       
    return view('show.create', compact('films', 'halls','results'));
}
    public function store(Request $request)
    {
        $data = $request->validate([
            'showtimes' => 'required|array',
            'F_id' => 'required',
            'showtimes.*.H_id' => 'required',
            'showtimes.*.H_id.*'=>'required',
            'showtimes.*.start_time' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
    
        $start_date = Carbon::parse($data['start_date']);
        $end_date = Carbon::parse($data['end_date']);
    
        $film = Film::where('F_id', $data['F_id'])->first();
        $release_date = Carbon::parse($film->release_date);
    
        if ($release_date <= $start_date) {
            while ($start_date <= $end_date) {
                $show = $film->Shows()->create([
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                ]);
                $show->save();

                    foreach ($data['showtimes'] as $showtime) {
                        $start_time = Carbon::parse($showtime['start_time']);
                        $end_time = $this->EndTime($start_time, $film->duration);
                                
                        // dd($showtime);
                        $new_showtime = $show->Showtimes()->create([
                            'start_time' => $start_time,
                            'end_time' => $end_time,
                          
                        ]);
                        
                        foreach ($showtime['H_id'] as $hall) {
                            $check = $this->checkOverlap($film, $start_date, $start_time, $hall);
                            if ($check) {
                                $show->delete();
                                $new_showtime->delete();
                                return redirect('/employee/show/create')->with('error', 'There is an overlap in showtimes.');
                            } else {
                                
                                if ($start_time->toTimeString() < '11:00:00' || $start_time->toTimeString() > '23:00:00') {
                                    $show->delete();
                                    $new_showtime->delete();
                                    return redirect('/employee/show/create')->with('error', 'Choose correct times.');
                                } else {
                                  
                                    $new_showtime->halls()->attach($hall);

                                    $seats = Seat::where('H_id', $hall)->get();
                                  
                                    $hall_showtime = Hall_Showtime::where('SHT_id', $new_showtime->SHT_id)
                                    ->where('H_id',$hall)->first();
                                   
                                    
                                         foreach ($seats as $seat) {
                                     
                                        $hall_showtime->seats()->attach($seat);
                                         
                                    }
                                }
                            }
                        }
                    }
    
                $start_date->addDay();
            }
    
            return redirect('/employee')->with('success', 'Showtimes have been created successfully.');
        } else {
            return redirect('/employee')->with('error', 'The film release date is after the start date.');
        }
    }
    private function checkOverlap($film, $start_date, $start_time, $hallId)
{
    $end_time = $this->EndTime($start_time, $film->duration);

    return ShowTime::join('hall_showtime', 'show_times.SHT_id', '=', 'hall_showtime.SHT_id')
        ->join('shows', 'show_times.SH_id', '=', 'shows.SH_id')
        ->where('hall_showtime.H_id', $hallId)
        ->where(function ($query) use ($start_date, $start_time, $end_time) {
            $query->where(function ($query) use ($start_date, $start_time) {
                $query->where('shows.start_date', '=', $start_date)
                    ->where('show_times.start_time', '<=', $start_time)
                    ->where('show_times.end_time', '>', $start_time);
            })->orWhere(function ($query) use ($start_date, $start_time, $end_time) {
                $query->where('shows.start_date', '=', $start_date)
                    ->where('show_times.start_time', '<', $end_time)
                    ->where('show_times.end_time', '>=', $end_time);
            });
        })->first();
}
    private function EndTime($start_time, $duration)
    {
        $start = Carbon::parse($start_time);
        $duration = Carbon::parse($duration);
    
        $end = $start->addHours($duration->hour)->addMinutes($duration->minute);
    
        return $end->format('H:i');
    }
    
    public function show($SHT_id, $H_id)
    {
        $showtime = Hall_Showtime::join('show_times', 'show_times.SHT_id', '=', 'hall_showtime.SHT_id')
            ->join('shows', 'shows.SH_id', '=', 'show_times.SH_id')
            ->join('films', 'films.F_id', '=', 'shows.F_id')
            ->join('halls', 'halls.H_id', '=', 'hall_showtime.H_id')
            ->where('hall_showtime.SHT_id', '=', $SHT_id)
            ->where('hall_showtime.H_id', '=', $H_id)
            ->first();
    
        return view('show.update', compact('showtime'));
    }
    
    public function update($SHT_id, $H_id, request $request){

      
        $showtime=Showtime::find($SHT_id);
        $hall_showtime=hall_showtime::where('hall_showtime.SHT_id',$SHT_id)->where('hall_showtime.H_id',$H_id)->first();
        // $seats=$hall_showtime->Seats();

        $results=hall_showtime::join('show_times','show_times.SHT_id','=','hall_showtime.SHT_id')
        ->join('shows','shows.SH_id','=','show_times.SH_id')->join('films','films.F_id','=','shows.F_id')
        ->join('halls','halls.H_id','=','hall_showtime.H_id')
        ->where('hall_showtime.SHT_id',$SHT_id) ->where('hall_showtime.H_id',$H_id)->first();

      
        $seats=Seat::join('seat_showtime','seat_showtime.SE_id','=','seats.SE_id')
        ->join('hall_showtime','hall_showtime.HS_id','=','seat_showtime.HS_id')
        ->join('show_times','show_times.SHT_id','=','hall_showtime.SHT_id')
        ->where('hall_showtime.H_id',$H_id)->where('hall_showtime.SHT_id',$SHT_id)
        ->get();
        // dd($seats)
        $start=carbon::parse($request->input('start_time'));
        $duration=$results->duration;
        $end=$this->EndTime($start,$results->duration);
        $start_date=$results->start_date;
        foreach($seats as $seat)
        {
            if($seat->status=='booked')
            {
                return redirect('/employee/show')->with('error', 'There is an booked seats in this showtimes.');
            }
        }

   
        $check=ShowTime::join('hall_showtime', 'show_times.SHT_id', '=', 'hall_showtime.SHT_id')
        ->join('shows', 'show_times.SH_id', '=', 'shows.SH_id')
        ->where('hall_showtime.H_id', $request->input('H_id'))
        ->where('show_times.SHT_id','!=',$SHT_id)
        ->where(function ($query) use ($start_date, $start, $end) {
            $query->where(function ($query) use ($start_date, $start) {
                $query->where('shows.start_date', '=', $start_date)
                    ->where('show_times.start_time', '<=', $start)
                    ->where('show_times.end_time', '>', $start);
            })->orWhere(function ($query) use ($start_date, $start, $end) {
                $query->where('shows.start_date', '=', $start_date)
                    ->where('show_times.start_time', '<', $end)
                    ->where('show_times.end_time', '>=', $end);
            });
        })->first();
        $check1=hall_showtime::where('SHT_id',$SHT_id)->where('H_id',$request->input('H_id'))->
        where('HS_id','!=',$hall_showtime->HS_id)->first();

        //  dd($check);
        
        if($check)
        {
          
                return redirect('/employee/show')->with('error', 'There is an overlap in showtimes.');
            }
            else
            {
                $showtime->update([
                    'start_time'=>$results->start_time,
                    'end_time'=>$results->end_time
                ]);

        if ($showtime && $hall_showtime)
        {
          
            if($results->start_time!=$request->input('start_time') && $results->H_id==$request->input('H_id'))
            {

         $showtime->update([
            'start_time'=>$start,
            'end_time'=>$end
         ]);
           

           return redirect('employee/show')->with('success','showtime updated');
        }
        elseif($results->start_time==$request->input('start_time') && $results->H_id!=$request->input('H_id')){
            //  dd($check1);
            
            $hall_showtime->update([
                'H_id'=>$request->input('H_id')
            ]);
            return redirect('employee/show')->with('success','hall updated');
        }
        elseif($results->start_time!=$request->input('start_time') && $results->H_id!=$request->input('H_id')){
            if ($check1){
                return redirect('/employee/show')->with('error', 'There is an overlap in halls.');
            }
            $showtime->update([
                'start_time'=>$start,
                'end_time'=>$end
    
               ]);
               $hall_showtime->update([
                'H_id'=>$request->input('H_id')
            ]);
            return redirect('employee/show')->with('success','everything has updated'); 
            
        }
        else{

            return redirect('employee/show')->with('error','no updates hace made');
        }

        }
    } 
  }

  public function delete($SHT_id,$H_id,$SH_id,$HS_id){
   
    
    $show=hall_showtime::join('show_times','hall_showtime.SHT_id','=','show_times.SHT_id')
    ->where('hall_showtime.SHT_id',$SHT_id)
    ->where('hall_showtime.HS_id','!=',$HS_id)
    ->first();
   
    $show1=Showtime::join('shows','show_times.SH_id','=','shows.SH_id')
    ->where('show_times.SH_id','=',$SH_id)
    ->where('show_times.SHT_id','!=',$SHT_id)
    ->first();

    $seats=Seat::join('seat_showtime','seat_showtime.SE_id','=','seats.SE_id')
    ->join('hall_showtime','hall_showtime.HS_id','=','seat_showtime.HS_id')
    ->join('show_times','show_times.SHT_id','=','hall_showtime.SHT_id')
    ->where('hall_showtime.H_id',$H_id)
    ->where('hall_showtime.SHT_id',$SHT_id)
    ->get();


    // dd($seats);
    foreach($seats as $seat)
    {
        if($seat->status=='booked')
        {
            return redirect('/employee/show')->with('error', 'There is an booked seats in this showtimes.');
        }
    }
    $showtime=hall_showtime::find($HS_id);
   
   
if (!$show1){
    if(!$show){
        $SHid=Show::find($SH_id);
        $SHid->delete();
        return redirect('/employee/show')->with('success','all are deleted');

    }
    else{

        $showtime->delete();
        return redirect('employee/show')->with('success','showtime deleted ');
    }

}
else{
    if(!$show){
        $SHTid=Showtime::find($SHT_id);
        $SHTid->delete();
        return redirect('/employee/show')->with('success','all elated  are deleted');

    }
    else{

        $showtime->delete();
        return redirect('employee/show')->with('success','showtime deleted ');
    }
}
  }
}