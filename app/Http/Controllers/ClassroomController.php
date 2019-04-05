<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;
use Validator;
use App\Classroom;
use App\Students;
use App\User;
use Auth;


class ClassroomController extends Controller
{
    public function handleAddClassroom()
    {
    	$data = Input::all();
    	//dd($data);
        $rules = [
          
            'title' => 'required|min:5',
            'computers' => 'required',
        ];

        $messages = [
            'title.required' => 'Votre titre est obligatoire',
            'title.min' => 'Votre titre doit dépasser 5 caractères',
          
            'computers.required' => 'Le champ computers est obligatoire'
        ];

        $validation = Validator::make($data, $rules, $messages);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors());
        }
    	$cl = Classroom::create([
    		'tables' => $data['tables'],
    		'computers' => $data['computers'],
    		'title'=>$data['title']
    	]);
    dd(now()->addDays(5));
    }

    public function handleDeleteClassroom($id)
    {
        //dd($id);
        /*
        $cl = Classroom::find($id);
        if ($cl){
            $cl->delete();
        }
        else{
            return 'ERREUR';
        }
        */

        /*
        $cl = Classroom::find($id);
        $delete = $cl ? $cl->delete() : null;
        return $delete? 'true' : 'false';
        */
          
        Classroom::whereId($id)->delete();
        //return redirect(route('listClassroom'));
        //return back()->withErrors(['La suppression a été effectuée']);
        //return back()->with('msg','La suppression a été effectuée');
        Session::flash('message', "Special message goes here");
        return back();

    }

    public function listClassroom()
    {
          $cl = Classroom::withCount('students')->get();
        // $cl = Classroom::all();
        return view('list',['cl'=>$cl]);

    }

    public function showClassroom($id)
    {
       //dd(Students::find($id)->with('classroom')->first());
       //dd(Classroom::find($id)->with('students')->first());
     
       /*$cl = Classroom::find($id);
       return view('show',['cl'=>$cl]);*/

    /*   if ($data = @file_get_contents("https://www.geoip-db.com/json"))
   {
       $json = json_decode($data, true);
       $latitude = $json['latitude'];
       $longitude = $json['longitude'];
   }
    dd($longitude, $latitude); */

    if ($data = @file_get_contents("http://api.apixu.com/v1/current.json?key=fc8ed0be1ed24dcb885144051190404&q=Tunis"))
   {
       $json = json_decode($data, true);
       $icone = $json['current']['condition']['icon'];

   }
    
$cl = Classroom::find($id);
       return view('show',['cl'=>$cl,'icone'=>$icone]);


    }

   public function handleUpdateClassroom($id){

       /* //$line = Classroom::find($id);
        $data = Input::all();
        //dd($data);
        $cl = Classroom::update([
            'tables' = $data['tables'],
            'computers' = $data['computers'],
            'title' = $data['title']
        ]);*/
   
    /* $data = Input::all();
        $cl = Classroom::where('id',$id)->update(
           [
               'tables'    => $data['tables'],
               'computers' => $data['computers'],
               'title'     => $data['title']
           ]
       );

        return redirect(route('showClassrooms'));
    */




        $cl = Classroom::find($id);
        

        $data = Input::all();
        $cl->tables = $data['tables'];
        $cl->computers = $data['computers'];
        $cl->title = $data['title'];
        $cl->save();
        return redirect(route('listClassroom'));
        
    }
    
    public function handleRegister(){
        $data = Input::all();
        dd(bcrypt($data['password']));
        $cl = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password'=>bcrypt($data['password']),
            
        ]);
    }
    public function showRegister()
    {
        return view('register');
    }

    public function showLogin()
    {
        return view('login');
    }

    public function handleLogin()
    { 
        $data = Input::all();
        $credentials = [
           'email' => $data['email'],
           'password' => $data['password'],
        ];
        if (Auth::attempt($credentials)) {
           $user = Auth::user();
           return $user;

          // dd($user);
        } 
        else 
        {
            return 'error'; 
        }

    }

    public function handleLogout()
    {
        Auth::logout();
        return redirect(Route('showLogin'));

    }

    public function showStudent($id)
    {
       

       $cl=Classroom::find($id);
       if($cl and $cl->students()->exists()){
       //dd($cl->students);
        return view('showStudent',['cl'=>$cl]);
       }
       else
       {
        return redirect(route('listClassroom'));
       }


    }

    public function handleDeleteStudent($id){
        $cl=Classroom::find($id);
       
       if (Auth::user()) {
          Students::whereId($id)->delete();
          return back();
       }

        

    }

}
