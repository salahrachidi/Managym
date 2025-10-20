<?php

namespace App\Http\Controllers;

use App\Models\notification;
use App\Models\package;
use Illuminate\Http\Request;

class packageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $packages = package::OrderBy('created_at','desc')->paginate(7);
        $NewUsersnotifications = notification::where('not_type','=','nu')->get();
        $nbrNotifications = notification::all()->count();
        $PayAlertsnotifications = notification::where('not_type','=','pa')->get();

        return view('package.index',[
            'packages'=>$packages,
            'nbrNotifications'=>$nbrNotifications,
            'NewUsersnotifications'=>$NewUsersnotifications,
            'PayAlertsnotifications'=>$PayAlertsnotifications,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('package.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request);
        $request->validate([
            'pac_title'=>'bail|required|string',
            'pac_duree'=>'bail|required|numeric',
            'pac_description'=>'bail|required|string',
            'pac_prix'=>'bail|required|numeric',
        ]);
        package::create([
            'pac_title'=>$request->input('pac_title'),
            'pac_duree'=>$request->input('pac_duree'),
            'pac_description'=>$request->input('pac_description'),
            'pac_prix'=>$request->input('pac_prix'),
        ]);
        return redirect('/packages')->with('success', 'package added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $package = package::find($id);
        $NewUsersnotifications = notification::where('not_type','=','nu')->get();
        $nbrNotifications = notification::all()->count();
        $PayAlertsnotifications = notification::where('not_type','=','pa')->get();

        return view('package.edit',[
            'package'=>$package,
            'nbrNotifications'=>$nbrNotifications,
            'NewUsersnotifications'=>$NewUsersnotifications,
            'PayAlertsnotifications'=>$PayAlertsnotifications,

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'pac_title'=>'bail|required|string',
            'pac_duree'=>'bail|required|numeric',
            'pac_description'=>'bail|required|string',
            'pac_prix'=>'bail|required|numeric',
        ]);
        package::find($id)->update([
            'pac_title'=>$request->input('pac_title'),
            'pac_duree'=>$request->input('pac_duree'),
            'pac_description'=>$request->input('pac_description'),
            'pac_prix'=>$request->input('pac_prix'),
        ]);
        return redirect('/packages')->with('successUp', 'package updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        package::find($id)->delete();
        return redirect('/packages')->with('successDel', 'package deleted successfully.');
    }
}
