<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;

class EmployeerController extends Controller
{
    public function createEmp(Request $request)
    {
        return view('admin.addEm');
    }

    public function storeEm(Request $request)
    {
        $role_id = 3;

$data = $request->validate([
    'f_name' => 'required|string',
    'l_name' => 'required|string',
    'email' => 'required|email|unique:employees',
    'password' => 'required|min:8',
]);

// Concatenate the first name and last name
$full_name = $data['f_name'] . ' ' . $data['l_name'];

// Create the employee with the provided role ID
$employee = Employee::create([
    'R_id' => $role_id,
    'f_name' => $data['f_name'],
    'l_name' => $data['l_name'],
    'email' => $data['email'],
    'password' => bcrypt($data['password']),
]);

// Create the user with the provided role ID and concatenated full name
$user = User::create([
    'R_id' => $role_id,
    'name' => $full_name,
    'email' => $data['email'],
    'password' => bcrypt($data['password']),
]);

// Other actions or redirects can be added here.

return redirect()->route('admin.index')->with('success', 'Employee created successfully');
    }
    

    public function createMan(Request $request)
    {
        return view('admin.addMa');
    }
    
    public function storeMan(Request $request)
    {
        $role_id = 2;

$data = $request->validate([
    'f_name' => 'required|string',
    'l_name' => 'required|string',
    'email' => 'required|email|unique:employees',
    'password' => 'required|min:8',
]);

// Concatenate the first name and last name
$full_name = $data['f_name'] . ' ' . $data['l_name'];

// Create the employee with the provided role ID
$employee = Employee::create([
    'R_id' => $role_id,
    'f_name' => $data['f_name'],
    'l_name' => $data['l_name'],
    'email' => $data['email'],
    'password' => bcrypt($data['password']),
]);

// Create the user with the provided role ID and concatenated full name
$user = User::create([
    'R_id' => $role_id,
    'name' => $full_name,
    'email' => $data['email'],
    'password' => bcrypt($data['password']),
]);

// Other actions or redirects can be added here.

return redirect()->route('admin.index')->with('success', 'Managers created successfully');
    }


    public function showEmp(){
    
        $employees=Employee::wherein('R_id',[2,3])->get();
        return view ('admin.employees',['employees'=>$employees]);
    

    }
    public function deleteEmp($id){
        $employee = Employee::find($id);
    
        if ($employee) {
            $employee->delete();
    
            $user = User::where('R_id', 3)->where('email', $employee->email)->first();
    
            if ($user) {
                $user->delete();
            }
    
            return redirect('/admin/employees')->with('success', 'Employee Deleted Successfully');
        } else {
            return redirect('/admin/employees')->with('error', 'Employee not found');
        }
    }
    
    public function admin_index(){

        return view ('admin.admin');
    }
    public function employee_index(){

        return view ('employee.index');
    }
    }
    