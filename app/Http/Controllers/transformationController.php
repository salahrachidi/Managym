<?php

namespace App\Http\Controllers;

use App\Models\coach;
use App\Models\notification;
use App\Models\personnel;
use App\Models\transformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class transformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $trans = transformation::OrderBy('created_at', 'desc')->paginate(6);
        $personnels = personnel::all()->where('per_role', '=', 0);
        $coaches = coach::all();
        $NewUsersnotifications = notification::where('not_type','=','nu')->get();
        $nbrNotifications = notification::all()->count();
        $PayAlertsnotifications = notification::where('not_type','=','pa')->get();

        //dd($trans);
        //dd($coaches);
        return view('transformation.index', [
            'trans' => $trans,
            'coaches' => $coaches,
            'personnels' => $personnels,
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
        $personnels = personnel::all()->where('per_role', '=', 0);
        $coaches = coach::all();
        return view('transformation.create', [
            'coaches' => $coaches,
            'personnels' => $personnels,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        //dd($request);
        $request->validate([
            'tra_description' => 'bail|required|string',
            'tra_pic1' => 'bail|image|mimes:png,jpeg,jpg',
            'tra_poid' => 'bail|required|numeric|required',
            'tra_duree' => 'bail|required|numeric',
            'personnel_id' => 'bail|required|numeric',
        ]);
        /*************************************/

        $newImageName1 = rand(10000, 99999) . '_' . time() . '_' . $request->Dtra_duree . '.' . $request->tra_pic1->extension();
        // dd($newImageName);
        $request->tra_pic1->move(public_path('images/transformations'), $newImageName1);
        /************************************/
        transformation::create([
            'tra_description' => $request->input('tra_description'),
            'tra_pic1' => $newImageName1,
            'tra_poid' => $request->input('tra_poid'),
            'tra_duree' => $request->input('tra_duree'),
            'coach_id' => $request->input('coach_id'),
            'personnel_id' => $request->input('personnel_id'),
        ]);
        //dd($transformation);
        return redirect('/transformations')->with('success', 'transfornatiom added successfully.');
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

        $personnels = personnel::all()->where('per_role', '=', 0);
        $transformation = transformation::find($id);
        $coaches = coach::all();
        //******image logic**************** */
        $photo1 = $transformation->tra_pic1;
        $photo2 = $transformation->tra_pic2;
        $NewUsersnotifications = notification::where('not_type','=','nu')->get();
        $nbrNotifications = notification::all()->count();
        $PayAlertsnotifications = notification::where('not_type','=','pa')->get();


        //******image logic**************** */
        return view('transformation.edit', [
            'tran' => $transformation,
            'coaches' => $coaches,
            'personnels' => $personnels,
            'photo1' => $photo1,
            'photo2' => $photo2,
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
        //dd($request);
        $request->validate([
            'tra_description' => 'bail|required|string',
            'tra_pic1' => 'bail|image|mimes:png,jpeg,jpg',
            'tra_poid' => 'bail|required|numeric|required',
            'tra_duree' => 'bail|required|numeric',
            'personnel_id' => 'bail|required|numeric',
        ]);
        // ********************************images logic
        $transformation = transformation::find($id);
        if($request->hasFile('tra_pic1')){
            $path1 = public_path('images/transformations/' . $transformation->tra_pic1);
                if (File::exists($path1)) {
                    File::delete($path1);
                }
            /*****************************************************************/
            //Save photo in the folder
            $newImageName =
            rand(10000, 99999) . '_' . time() . '_' . $request->Con_date . '.' . $request->tra_pic1->extension();
            // dd($newImageName);
            $request->tra_pic1->move(public_path('images/transformations'), $newImageName);
            /*****************************************************************/
        }else{
            $newImageName = $transformation->tra_pic1;
        }

        // ********************************images logic
        transformation::find($id)->update([
            'tra_description' => $request->input('tra_description'),
            'tra_pic1' => $newImageName,
            'tra_poid' => $request->input('tra_poid'),
            'tra_duree' => $request->input('tra_duree'),
            'coach_id' => $request->input('coach_id'),
            'personnel_id' => $request->input('personnel_id'),
        ]);
        return redirect('/transformations')->with('successUp', 'transfornatiom updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $transformation = transformation::find($id);
        $path1 = public_path('images/transformations/' . $transformation->tra_pic1);
        if (File::exists($path1)) {
            File::delete($path1);
        }
        transformation::find($id)->delete();
        return redirect()->back()->with('successDel', 'transformation deleted successfully.');
    }
}
