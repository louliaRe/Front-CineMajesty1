<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hall;
use App\Models\Seat;
use App\Models\Type;

class HallController extends Controller
{
    public function show(){

        $halls=Hall::all();
        $types=Type::all();
        return view('hall.index',compact('halls','types'));
        
    }
    public function create(){

        $types=Type::all();
        $halls=Hall::all();
        return view('hall.create',compact('types'));

    }
    public function store(request $request){

        $data=$request->validate([
            'total_seats'=>'required|integer',
              'col_nums'=>'required|integer',
              'row_nums'=>'required|integer',
              'price'=>'required|integer',
            
        ]);
      
        $col_nums=$data['col_nums'];
        $row_nums=$data['row_nums'];

        if($data['total_seats']==$data['col_nums']*$data['row_nums']){

            if(!$request->input('name')&&$request->input('TY_id'))
            {

      $hall=Hall::create([
        'total_seats'=>$data['total_seats'],
        'TY_id'=>$request->input('TY_id'),
        'status'=>$request->input('status'),
        'price'=>$data['price']
      ]);
    
           }
      elseif($request->input('name')&& !$request->input('TY_id'))
      {
        $check=Type::where('name',$request->input('name'))->first();

        if(!$check){
        $type=Type::create([
            'name'=>$request->input('name'),
        ]);
        $type->save();
        $tyId=$type->TY_id;

        $hall=Hall::create([
            'total_seats'=>$data['total_seats'],
            'TY_id'=>$tyId,
            'status'=>$request->input('status'),
            'price'=>$data['price']
    
          ]);}
          elseif($check){       
            return redirect('employee/halls/create')->with('error','this type of halls is already existed');
          }
      }
      elseif($request->input('name')&&$request->input('TY_id')){
        return redirect('employee/halls/create')->with('error','please choose the type of the hall carefully');
      }
      elseif(!$request->input('name')&&!$request->input('TY_id')){
        return redirect('employee/halls/create')->with('error','please choose the type of the hall carefully');
      }
    
     $hall_id=$hall->H_id;
      for($row=1;$row<=$row_nums;$row++)
      {
        for($col=1;$col<=$col_nums;$col++)
        {
            $seat=Seat::create
            ([
    'H_id'=>$hall_id,
    'seat_num'=>$col.'-'.$row,
    'seat_row'=>$row,
    'seat_col'=>$col,
            ]);
        }
          }


      return redirect()->route('hall.show')->with('success','halls created succesfully');
        }
        else{
    
            return redirect()->route('hall.show')->with('error','halls didnt created ');

        }
    }


    public function delete($id){
        $hall = hall::find($id);
    
        if ($hall) {
            $hall->delete();
    
            return redirect('/employee/halls')->with('success', 'hall Deleted Successfully');
        } else {
            return redirect('/employee/halls')->with('error', 'hall not found');
        }
    }
    
    public function update(Request $request, $id)
{
    $hall = Hall::find($id);
    
    // Validate and update hall data
    $hall->update($request->all());

    return redirect('/employee/halls')->with('success', 'Hall updated successfully');
}

    public function getH($id){
 
        $types=Type::all();
        $hall=Hall::find($id);


        return view ('hall.update',compact('hall','types'));


    }
}
