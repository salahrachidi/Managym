<?php

namespace App\Http\Controllers;

use App\Models\coach;
use App\Models\package;
use Illuminate\Http\Request;
use App\Models\personnel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class authController extends Controller
{
    //
    function index()
    {
    return view('users.home.home');
    }
    public function login(){

        return view('users.home.login');
    }
    public function Plogin(Request $request){
        //dd($request);
        $request->validate([
            'email'=>'bail|required|email',
            'password'=>'bail|required',
        ]);
        $user = personnel::where('per_email','=',$request->email)->first();
        if($user){
            if(Hash::check($request->password,$user->per_password)){
                $name = $user->per_nom;
                $role = $user->per_role;
                $request->session()->put('user_id',$user->id);
                $request->session()->put('user_nom',$user->per_nom);
                $request->session()->put('user_role',$user->per_role);
                $request->session()->put('user_prenom',$user->per_prenom);
                $request->session()->put('user_photo',$user->per_pic);
                $request->session()->put('user_email',$user->per_email);
                //check first inscription
                $result = DB::selectOne('CALL CheckPersonnelPayments(?)', [$user->id]);
                $hasPayments = $result->has_payments;
                
                //check first inscription
                if( $role == '1'){
                    return redirect('/dashboard')->with('welcome',$name);
                }else{
                    if($hasPayments == 0){
                        return redirect('/profile')->with('welcome',$name);
                    }else{
                        $request->session()->put('newUser',1);
                        return redirect('/AccountActivation/' . $user->id);
                    }
                }
            }else{
                return back()->with('error','mot de passe incorrect');
            }
        }else{
            return back()->with('error','email incorrect');
        }

    }
    public function register(){
        
        $coaches = coach::all();
        $packages = package::all();
        return view('users.home.register',[
            'coaches'=>$coaches,
            'packages'=>$packages,
        ]);
    }
    public function Pregister(Request $request){
        $request->validate([
            'per_nom'=>'bail|required|string|max:15',
            'per_prenom'=>'bail|required|string|max:20',
            'per_tel'=>'bail|required|string|max:20',
            'per_sexe'=>'bail|required|string',
            'per_email'=>'bail|required|email|unique:personnels',
            'package_id'=>'bail|required',
            'password'=>'bail|required|min:8',
        ]);
        //dd($request);
        /*****************************************************************/
        // dd($request->per_pic->extension());
        //Save photo in the folder
        if($request->hasFile('per_pic')){
            $imagelink = rand(10000, 99999) . '_' . time() . '_' . $request->per_tel . '.' .$request->per_pic->extension();
            // dd($imagelink);
            $request->per_pic->move(public_path('images/profiles'), $imagelink);
        }
        /*****************************************************************/
        personnel::create([
            'per_nom'=>$request->per_nom,
            'per_prenom'=>$request->per_prenom,
            'per_tel'=> $request->per_tel ,
            'per_pic'=> null,
            'per_sexe'=> $request->per_sexe,
            'per_email'=> $request->per_email,
            'per_password'=>Hash::make($request->password),
            'package_id'=>$request->package_id,
            'coach_id'=>$request->coach_id,
        ]);
        // return redirect('/login')->with('registred','compte cree avec success');
        return redirect('/home/login');
    }
    public function logout(){
        if(Session::has('user_email')){
            Session::pull('user_id');
            Session::pull('user_nom');
            Session::pull('user_prenom');
            Session::pull('user_photo');
            Session::pull('user_email');
            if(Session()->has('newUser')){
                Session::pull('newUser');
            }
            return redirect('/home/login');
        }
    }
    public function ActivateAccount(String $id){
        $user = personnel::find($id);
        $controleQR = "Member's full name : ".' '.$user->per_nom.'_'.$user->per_prenom . PHP_EOL
                    ."Member's Subscription price : ".' '.$user->package->pac_prix.PHP_EOL
                    ."Member's Phone Number :".' '.$user->per_tel.PHP_EOL
                    ."Member's id :".$user->id;
        $qr = QrCode::size(200)
                    ->style('dot')
                    ->eye('circle')
                    ->color(223, 169, 122)
                    ->margin(1)
                    ->generate(
            $controleQR,
        );
        return view('facture.index',[
            "user"=>$user,
            'qr'=>$qr,
        ]);
    }

}

