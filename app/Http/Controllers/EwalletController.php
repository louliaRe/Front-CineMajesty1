<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Wallet;


class EwalletController extends Controller
{
    public function create(){

        return view('wallet.create');
    }
    public function store(request $request){
      $email = auth()->user()->email;
      $customer=Customer::where('email',$email)->first();
      $id= $customer->C_id;

   $data=$request->validate([
   'address'=>'required|string',
   'PIN'=>'required|min:4'
   ]);
   
   
   $check=$this->check($id);

   if($check){
   
     return redirect('/employee')->with('error','no');

   }
     else{
   $customer->wallet()->create([
    'C_id'=>$id,
    'amount'=>0, 
  'address'=>$data['address'],
  'PIN'=>bcrypt($data['PIN'])
   ]);
   return redirect('employee/')->with('success','wallet added');

     }
    }

    function check ($id){

   return Wallet::join('customers','customers.C_id','=','_e_wallets.C_id')->where('customers.C_id',$id)->first();

    }

    public function getC()
    {
        $customers = Customer::join('_e_wallets', '_e_wallets.C_id', '=', 'customers.C_id')
            ->select('customers.*', '_e_wallets.EW_id')
            ->get();
    
        return view('wallet.index', compact('customers'));
    }

   public function show($id){

    $wallet=Wallet::where('EW_id',$id)->first();
     return view('wallet.update',compact('wallet'));

   }

   public function update($id,request $request){

    $wallet=Wallet::find($id);
    
    $wallet->update($request->all());
    return redirect()->route('wallet.index');
    
   }
    }

