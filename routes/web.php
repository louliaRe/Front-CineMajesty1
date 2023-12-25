<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\FilmController::class,'welcome_films'])->name('welcome');
Route::get('/film/filter', [App\Http\Controllers\FilmController::class,'filterbygener'])->name('film.filter');
Route::post('/film/comment/{F_id}',[App\Http\Controllers\CommentController::class,'store'])->name('comment.store');
// Route::post('/film/upload',[App\Http\Controllers\FilmController::class,'upload'])->name('film.upload');
Route::get('/film/search',[App\Http\Controllers\SearchController::class,'searchFilm'])->name('search.resaults');
Route::get('/film/{id}',[App\Http\Controllers\FilmController::class,'show'])->name('film.show');

Route::middleware(['admin'])->group(function () {
    Route::get('/admin', [App\Http\Controllers\EmployeerController::class, 'admin_index'])->name('admin.index');

    // Employee Routes
    Route::get('/admin/employees/create', [App\Http\Controllers\EmployeerController::class, 'createEmp'])->name('employee.create');
    Route::post('/admin/employees', [App\Http\Controllers\EmployeerController::class, 'storeEm'])->name('employee.store');
    Route::get('/admin/employees', [App\Http\Controllers\EmployeerController::class, 'showEmp'])->name('employee.show');
    Route::delete('/admin/employees/{id}', [App\Http\Controllers\EmployeerController::class, 'deleteEmp'])->name('employee.delete');
    
    // Manager Routes
    Route::get('/admin/managers/create', [App\Http\Controllers\EmployeerController::class, 'createMan'])->name('manager.create');
    Route::post('/admin/managers', [App\Http\Controllers\EmployeerController::class, 'storeMan'])->name('manager.store'); 
    Route::get('/admin/employees/search', [App\Http\Controllers\SearchController::class, 'searchEmp'])->name('employee.resaults');
    Route::delete('/admin/employees/search/{id}', [App\Http\Controllers\EmployeerController::class, 'deleteEmp'])->name('search.delete');


});


Route::middleware(['manager'])->group(function () {
    Route::get('/manager', function () {
        return view('manager');
    });
});
Route::middleware(['employee'])->group(function () 
{
    Route::get('/employee',[App\Http\Controllers\EmployeerController::class, 'employee_index'])->name('employee.index');

    //film routes
    Route::get('/employee/film/create',[App\Http\Controllers\FilmController::class, 'create'])->name('film.create');
    Route::post('/employee/film/store',[App\Http\Controllers\FilmController::class, 'store'])->name('film.store');
    Route::get('/employee/film/show/create',[App\Http\Controllers\FilmController::class, 'storeSh'])->name('show.store');
    Route::post('/employee/film/show',[App\Http\Controllers\FilmController::class, 'storeSh'])->name('show.store');

    //cast routes
    Route::get('/employee/cast/create/{id}',[App\Http\Controllers\CastController::class, 'create'])->name('cast.create');
    Route::post('employee/cast/store/{F_id}',[App\Http\Controllers\CastController::class, 'store'])->name('cast.store');


    //schedule Routes
    
    Route::get('/employee/show/create',[App\Http\Controllers\ShowController::class, 'create'])->name('show.create');
    Route::post('/employee/show/store',[App\Http\Controllers\ShowController::class, 'store'])->name('show.store');
  Route::get('/employee/show',[App\Http\Controllers\ShowController::class, 'index'])->name('show.index');
  Route::get('/employee/show/{SHT_id}/{H_id}', [App\Http\Controllers\ShowController::class, 'show'])->name('show.show');
  Route::put('/employee/show/{SHT_id}/{H_id}/update',[App\Http\Controllers\ShowController::class, 'update'])->name('show.update');
  Route::delete('/employee/show/{SHT_id}/{H_id}/{SH_id}/{HS_id}/delete', [App\Http\Controllers\ShowController::class, 'delete'])->name('show.delete');



    //Wallet Routes 
    Route::get('employee/wallet/search',[App\Http\Controllers\SearchController::class,'searchcus'])->name('customer.results');

    Route::get('employee/wallets',[App\Http\Controllers\EWalletController::class,'getc'])->name('wallet.index');

    Route::get('employee/wallet/{id}',[App\Http\Controllers\EwalletController::class,'show'])->name('wallet.show');
    Route::put('employee/wallet/{id}',[App\Http\Controllers\EwalletController::class,'update'])->name('wallet.update');


    //offers Routes

    Route::get('employee/offers',[App\Http\Controllers\OfferController::class,'index'])->name('offers.show'); 
    Route::get('employee/offers/create',[App\Http\Controllers\OfferController::class,'create'])->name('offers.create'); 
    Route::post('employee/offers/store',[App\Http\Controllers\OfferController::class,'store'])->name('offers.store'); 


 //hall routes
 Route::get('/employee/halls/create', [App\Http\Controllers\HallController::class, 'create'])->name('hall.create');
 Route::post('/employee/halls', [App\Http\Controllers\HallController::class, 'store'])->name('hall.store');
 Route::get('/employee/halls', [App\Http\Controllers\HallController::class, 'show'])->name('hall.show');
 Route::delete('/employee/hall/{id}/delete', [App\Http\Controllers\HallController::class, 'delete'])->name('hall.delete');
 Route::get('employee/halls/{id}',[App\Http\Controllers\HallController::class, 'getH'])->name('hall.info');
 Route::put('/employee/hall/{id}/update',[App\Http\Controllers\HallController::class, 'update'])->name('hall.update');
 

 //snacks Routes 
 Route::get('/employee/snack',[App\Http\Controllers\SnackController::class, 'index'])->name('snack.index');
 Route::get('/employee/snack/create', [App\Http\Controllers\SnackController::class, 'create'])->name('snack.create');
 Route::post('/employee/snack/store', [App\Http\Controllers\SnackController::class, 'store'])->name('snack.store');
 Route::delete('/employee/snack/{id}/delete', [App\Http\Controllers\SnackController::class, 'delete'])->name('snack.delete');
 Route::get('/employee/snack/{id}/show', [App\Http\Controllers\SnackController::class, 'show'])->name('snack.show');
 Route::put('/employee/snack/{id}/update',[App\Http\Controllers\SnackController::class, 'update'])->name('snack.update');

 
 
// Route::get('/film/upload',[App\Http\Controllers\FilmController::class,'Gupload'])->name('film.Gupload');


 

});

Route::middleware(['customer'])->group(function () {
  
Route::get('customer/films',[App\Http\Controllers\FilmController::class, 'index'])->name('film.index');

Route::get('film/booking/{SHT_id}/{H_id}/{age}',[App\Http\Controllers\BookingController::class,'show'])->name('booking.show');
Route::post('film/booking/store/{SHT_id}',[App\Http\Controllers\BookingController::class,'submitjob'])->name('booking.submitjob');
Route::get('customer/wallet/create',[App\Http\Controllers\EwalletController::class, 'create'])->name('wallet.create');
Route::post('customer/wallet/store',[App\Http\Controllers\EwalletController::class,'store'])->name('wallet.store');
Route::post('/rate',[App\Http\Controllers\RateController::class,'Rate'])->name('rate.app');
Route::post('/rate/film/{F_id}',[App\Http\Controllers\RateController::class,'RateFilm'])->name('rate.film');
Route::get('/bookings',[App\Http\Controllers\BookingController::class,'index'])->name('booking.index');
Route::get('/bookings/update/{B_id}',[App\Http\Controllers\BookingController::class,'update'])->name('booking.update');
Route::delete('/bookings/delete/{B_id}',[App\Http\Controllers\BookingController::class,'delete'])->name('booking.delete');
Route::get('/bookings/edit/{B_id}/{SHT_id}/{H_id}',[App\Http\Controllers\BookingController::class,'edit'])->name('booking.edit');
Route::put('/bookings/update/{B_id}/{H_id}/{SHT_id}',[App\Http\Controllers\BookingController::class,'update'])->name('booking.update');



});


 
    

    










Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');













  // $film = App\Models\Film::find(1); // Assuming 1 is the ID of the specific Film
    // $show = $film->shows()->create([
    //     'date' => '2030-05-03',
    //     'price' => 20
    // ]);
    // $halls=App\Models\Hall::create([

    //     'total_seats'=>100,
    //     'type'=>'VIP'

    //  ]);
    // $film = App\Models\Film::find(1); // Assuming 1 is the ID of the specific Film
    // $show = $film->shows()->create([
    //     'date' => '2030-05-03',
    //     'price' => 20,
    //     // Other fields
    // ]);
    
    // $show = App\Models\Show::find(1); // Replace 1 with the actual Show ID
    // $hall = App\Models\Hall::find(1); // Replace 1 with the actual Hall ID
    
    // if ($show && $hall) {
    //     $showtime = new App\Models\Showtime([
    //         'start_time' => '15:00:00',
    //         'end_time' => '16:00:00',
    //     ]);
    
    //     // Associate the Show and Hall with the Showtime
    //     $showtime->show()->associate($show);
    //     $showtime->hall()->associate($hall);
    
    //     // Save the Showtime record
    //     $showtime->save();
    // $customer= App\Models\Customer::create([
    //     'f_name'=>'feras',
    //     'l_name'=>'khalil',
    //     'email'=>'feras@gmail.com',
    //     'password'=>bcrypt('feras123'),
    //     'age'=>22,
    //     'gender'=>'male'


    // ]);
    // $customer=App\Models\Customer::find(1);
    // $customer->E_Wallet()->create([
    //     'amount'=>200,
    //     'addrsss'=>'damascus',
    //     'PIN'=>1234,


    // ]);


    
//     $role_id=2;
//     $user=App\Models\User::create(
// [
//     'R_id'=>$role_id,
//     'name'=>'rana',
//     'email'=>'rana@gmail.com',
//     'password'=>bcrypt('rana1234')

// ]
// // //  );
    // $role_id=4;
//     $user=App\Models\User::create(
// [
//     'R_id'=>$role_id,
//     'name'=>'kareem',
//     'email'=>'kareem@gmail.com',
//     'password'=>bcrypt('kareem1234')

// ]
//  );
    
// $film=App\Models\Film::create([
//     'name'=>'hangover 2 ',
//    'description'=>'the hangover franchise',
//    'gener'=>'comedy',
//    'age_req'=>18,
//    'duration'=>160,
//    'image'=>'sssw'



// ]);