<?php

namespace App\Http\Controllers;
use App\Models\Snack;
use App\Models\Category;
use Illuminate\Http\Request;

class SnackController extends Controller
{
    public function index(){
        $snacks=Snack::join('images','images.S_id','=','snacks.S_id')->get();

        return view('snack.index',compact('snacks'));

    }
    public function create (){
        $categories=Category::all();
        return view('snack.create',compact('categories'));

    }
    public function store(request $request){
        $data=$request->validate([
            'name'=>'required|String',
            'price'=>'required|integer',
            'qty'=>'required|integer',
            'limit'=>'required|integer',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
           
          
        ]);
      
        $check=Snack::where('name',$data['name'])->first();
        if(!$check){
        if($request->input('CAT_id') && !$request->input('c_name'))
        {
            $cid=Category::where('CAT_id',$request->input('CAT_id'))->first();
        $snack=$cid->Snacks()->create([
            'name'=>$data['name'],
            'price'=>$data['price'],
            'qty'=>$data['qty'],
            'limit'=>$data['limit'],
           ]);
          
        $image_path=$request->file('image_path')->store('images','public');
        $snack->Images()->create(['image_path'=>$image_path]);
        return redirect('employee/snack')->with('success','Snack is Created');
        
    }
    elseif(!$request->input('CAT_id') && $request->input('c_name')){
        $find=Category::where('name', $request->input('c_name'))->first();
        if(!$find){
        $category=Category::create([
            'name'=>$request->input('c_name')
        ]);
        $category->save();
       $caid= $category->CAT_id;
    
        $snack=$category->Snacks()->create([
            'name'=>$data['name'],
            'price'=>$data['price'],
            'qty'=>$data['qty'],
            'limit'=>$data['limit'],
        ]);
        
        
        $image_path=$request->file('image_path')->store('images','public');
        $snack->Images()->create(['image_path'=>$image_path]);
        return redirect('employee/snack')->with('success','Snack is Created');
        }
        elseif($find){
            return redirect('employee/snack')->with('success','category is alreeady Created');
        
        }

        }
    elseif($request->input('CAT_id') && $request->input('c_name')){
        return redirect('employee/snack/create')->with('error','please choose the category');
         }
         elseif(!$request->input('CAT_id') && !$request->input('c_name')){
            return redirect('employee/snack/create')->with('error','please choose the category');
             }

         
        }
        else
        {
            return redirect('employee/snack')->with('error','Such snack is existed');

        }


    }
    public function delete($id){
        $Sid=Snack::find($id);
        if($Sid){
            $Sid->delete();
         return redirect('employee/snack')->with('deleting is comppleted');
        }
        else{
            return redirect('employee/snack')->with('there is no such snack ');
        }
    }
    public function show($id){
        $snack=Snack::find($id);
        if($snack){
         return view('snack.update',compact('snack'));
        }
        else{
            return redirect('employee/snack')->with('there is no such snack ');
        }
    }
    public function update($id,request $request){
        $snack=Snack::find($id);
        $data=$request->validate([
            'name'=>'String',
            'qty'=>'integer',
            'limit'=>'integer',
            'price'=>'integer'
        ]);
        if($snack){
            $snack->update([
                'name'=>$data['name'],
                'qty'=>$data['qty'],
                'limit'=>$data['limit'],
                'price'=>$data['price'],
            ]);
            $snack->save();
            return redirect('employee/snack')->with('deleting is comppleted');
           }
           else{
               return redirect('employee/snack')->with('there is no such snack ');
           }
    }

}

