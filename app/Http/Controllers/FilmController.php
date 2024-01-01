<?php

namespace App\Http\Controllers;
use App\Models\Film;
use App\Models\Customer;
use App\Models\Cast;
use App\Models\Hall;
use App\Models\Genre;
use App\Models\ShowTime;
use App\Models\Show;
use App\Models\Seat;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Comment;
use Illuminate\Support\Facades\Storage;

class FilmController extends Controller
{
    public function welcome_films()
    {
       
$current = Carbon::now()->format('Y-m-d');
$films=Film::join('shows','shows.F_id','=','films.F_id')
->where('shows.end_date','>=',$current)
->select('films.*')
->distinct()->get();

 $geners=Genre::all();



return view('welcome',compact('films','geners'));
    }

    public function filterbygener(request $request)
    {
        $genre=$request->input('genre');
        $films=Film::ByGenre($genre)->select('films.*')->get();
    
        return view('film.filter',compact('films'));
    }
public function create(){

    $casts=Cast::all();
    $geners=Genre::all();

return view('film.create', compact('casts', 'geners'));
}

public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string',
        'description' => 'required|string',
        'age_req' => 'required|integer',
        'duration' => 'required|date_format:H:i',
        'image_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'video_path' => 'required|mimes:mp4,avi,mov',
        'release_date' => 'required|date',
       
    ]);
   $edit=$request->input('editable');
  $value=0;
  if($edit == 'no'){
    $value = 0 ;
  }
  else{
    $value = 1;
  }

    $fil_check=Film::where('name',$data['name'])->first();

    if (!$fil_check){
            
    $film = Film::create([
        'name' => $data['name'],
        'description' => $data['description'],
        'age_req' => $data['age_req'],
        'release_date' => $data['release_date'],
        'duration' => $data['duration'],
        'value_cut'=>$request -> input('value_cut'),
        'time_allowed'=>$request -> input('time_allowed'),
        'editable'=> $value
    ]);

  $film->save();
  
  

    $geners = $request->input('gener', []);
    $film->Genres()->attach($geners);

    $imagepath = $request->file('image_path')->store('images', 'public');
    $film->Images()->create(['image_path' => $imagepath]);

    $videopath = $request->file('video_path')->store('videos', 'public');
    $film->Videos()->create(['video_path' => $videopath]);
    
    $id=$film->F_id;

    return redirect()->route('cast.create',['id'=>$id]);
}
     else {
        return redirect('/employee/film/create')->with('error', 'Invalid date range.');
    }
}

public function index(){
    $films=Film::all();
    return view('Film.index',compact('films'));
}
public function show($id){
    $age=Film::where('films.F_id',$id)->first()->age_req;
    $film = Film::join('images', 'images.F_id', '=', 'films.F_id')
        ->join('videos', 'videos.F_id', '=', 'films.F_id')
        ->where('films.F_id', $id)
        ->first();

        
    $casts=Cast::join('cast_film','cast_film.CA_id','=','casts.CA_id')
    ->join('films','films.F_id','=','cast_film.F_id')
    ->where('films.F_id',$id)
    ->get();
    
    $genres=Genre::join('film_genre','film_genre.G_id','=','genres.G_id')
    ->join('films','films.F_id','=','film_genre.F_id')
    ->where('films.F_id',$id)
    ->get();


    $shows=Show::join('show_times','show_times.SH_id','=','shows.SH_id')
    ->join('hall_showtime','hall_showtime.SHT_id','=','show_times.SHT_id')
    ->join('halls','halls.H_id','=','hall_showtime.H_id')
    ->join('types','halls.TY_id','=','types.TY_id')
    ->join('films','films.F_id','=','shows.F_id')
    ->where('films.F_id',$id)
    ->select('halls.H_id as H_id','shows.*','show_times.*','types.name as T_name')
    ->get();
    
    
    $comments=Comment::where('F_id',$id)->get();
    

   
    return view('film.show',compact('film','shows','genres','casts','comments','age'));
}




// public function upload(Request $request){
//     $film=Film::find(1);
//     $path = $request->file('movie')->store('movies', ['disk' => 'local']);
//         $url = Storage::url($path);

//     $film->videos()->create([
//         'video_path'=>$path,
//         'url'=>$url
//     ]);


//     return redirect('/')->with('succes','the film is uploaded');

// }

}
