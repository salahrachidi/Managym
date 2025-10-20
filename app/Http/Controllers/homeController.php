<?php

namespace App\Http\Controllers;

use App\Models\coach;
use App\Models\package;
use App\Models\personnel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class homeController extends Controller
{
    //
    function index()
    {
        return view('users.home.home');
    }


    function create()
    {
        $packages = package::all();
        $coaches = coach::all();
        return view('users.home.register', [
            'packages' => $packages,
            'coaches' => $coaches
        ]);
    }
    // ////////////////////
    function store(Request $request)
    {
        $request->validate([
            'per_nom' => 'bail|required|string',
            'per_prenom' => 'bail|required|string',
            'per_tel' => 'bail|required',
            'per_sexe' => 'bail|required|numeric',
            'per_email' => 'bail|required|email',
            'per_password' => 'bail|required',
            'package_id' => 'bail|required',
            'coach_id' => 'bail|required',
        ]);

        // personnel::create([
        //     'per_nom' => $request->input('per_nom'),
        //     'per_prenom' => $request->input('per_prenom'),
        //     'per_tel' => $request->input('per_tel'),
        //     'per_sexe' => $request->input('per_sexe'),
        //     'per_email' => $request->input('per_email'),
        //     'per_password' => Hash::make($request->input('per_password')),
        //     'package_id' => $request->input('package_id'),
        //     'coach_id' => $request->input('coach_id'),
        // ]);
        $createNewUser = new personnel;
        $createNewUser->per_nom = $request->per_nom;
        $createNewUser->per_prenom = $request->per_prenom;
        $createNewUser->per_tel = $request->per_tel;
        $createNewUser->per_sexe = $request->per_sexe;
        $createNewUser->per_email = $request->per_email;
        $createNewUser->per_password = $request->per_password;
        $createNewUser->package_id = $request->package_id;
        $createNewUser->coach_id = $request->coach_id;
        $createNewUser->save();

        Mail::send('users.home.sendEmail', function ($message) use ($request) {
            $message->to($request->per_email);
            $message->subject('ji tkhalss');
        });

        return redirect()->route('/home/login');
    }
    // ////////////////////

    function login()
    {
        return view('users.home.login');
    }


    //  register

}
