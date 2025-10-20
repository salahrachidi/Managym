<?php

namespace App\Http\Controllers;

use App\Models\coach;
use App\Models\notification;
use App\Models\package;
use App\Models\personnel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class personnelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $members = personnel::where('per_role', '=', 0)->orderBy('created_at', 'desc')->paginate(6);
        $packages = package::all();
        $coaches = coach::all();
        $NewUsersnotifications = notification::where('not_type','=','nu')->get();
        $nbrNotifications = notification::all()->count();
        $PayAlertsnotifications = notification::where('not_type','=','pa')->get();

        return view('members.index', [
            'members' => $members,
            'packages' => $packages,
            'coaches' => $coaches,
            'NewUsersnotifications'=>$NewUsersnotifications,
            'nbrNotifications'=>$nbrNotifications,
            'PayAlertsnotifications'=>$PayAlertsnotifications,

            
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $packages = package::all();
        $coaches = coach::all();
        return view('members.create', [
            'packages' => $packages,
            'coaches' => $coaches
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'per_nom' => 'bail|required|string',
            'per_prenom' => 'bail|required|string',
            'per_tel' => 'bail|required',
            'per_sexe' => 'bail|required|numeric',
            // 'per_pic'=>'bail',
            'per_email' => 'bail|required|email',
            'per_password' => 'bail|required',
            'per_status' => 'bail|required|numeric',
            'package_id' => 'bail|required|numeric',
            'coach_id' => 'bail|required|numeric',
        ]);
        /*****************************************************************/
        //Save photo in the folder
        $newImageName = rand(1000, 9999) . '_' . time() . '_' . $request->per_tel . '.' . $request->per_pic->extension();
        // dd($newImageName);
        $request->per_pic->move(public_path('images/profiles'), $newImageName);
        /*****************************************************************/
        personnel::create([
            'per_nom' => $request->input('per_nom'),
            'per_prenom' => $request->input('per_prenom'),
            'per_tel' => $request->input('per_tel'),
            'per_sexe' => $request->input('per_sexe'),
            'per_pic' => $newImageName,
            'per_email' => $request->input('per_email'),
            'per_password' => Hash::make($request->input('per_password')),
            'per_status' => $request->input('per_status'),
            'package_id' => $request->input('package_id'),
            'coach_id' => $request->input('coach_id'),
        ]);

        return redirect('/members')->with('success', 'member added successfully.');
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
        $packages = package::all();
        $coaches = coach::all();
        $member = personnel::find($id);
        $photo1 = $member->per_pic;
        $NewUsersnotifications = notification::where('not_type','=','nu')->get();
        $nbrNotifications = notification::all()->count();
        $PayAlertsnotifications = notification::where('not_type','=','pa')->get();
        return view('members.edit', [
            'member' => $member,
            'packages' => $packages,
            'coaches' => $coaches,
            'photo1' => $photo1,
            'NewUsersnotifications'=>$NewUsersnotifications,
            'nbrNotifications'=>$nbrNotifications,
            'PayAlertsnotifications'=>$PayAlertsnotifications,

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        // dd($request);
        $request->validate([
            'per_nom' => 'bail|required|string',
            'per_prenom' => 'bail|required|string',
            'per_tel' => 'bail|required',
            'per_sexe' => 'bail|required|numeric',
            // 'per_pic'=>'bail|required',
            'per_email' => 'bail|required|email',
            'per_password' => 'bail|required',
            'per_status' => 'bail|required|numeric',
            'package_id' => 'bail|required|numeric',
            'coach_id' => 'bail|required|numeric',
        ]);
        $member = personnel::find($id);
        if ($request->per_pic == null) {
            $newImageName = $request->photo1;
        } else {
            $path1 = public_path('images/profiles/' . $member->per_pic);
            if (File::exists($path1)) {
                File::delete($path1);
            }
            /*****************************************************************/
            //Save photo in the folder
            $newImageName = rand(1000, 9999) . '_' . time() . '_' . $request->per_tel . '.' . $request->per_pic->extension();
            // dd($newImageName);
            $request->per_pic->move(public_path('images/profiles'), $newImageName);
            /*****************************************************************/
        }
        personnel::find($id)->update([
            'per_nom' => $request->input('per_nom'),
            'per_prenom' => $request->input('per_prenom'),
            'per_tel' => $request->input('per_tel'),
            'per_sexe' => $request->input('per_sexe'),
            'per_pic' => $newImageName,
            'per_email' => $request->input('per_email'),
            'per_password' => Hash::make($request->input('per_password')),
            'per_status' => $request->input('per_status'),
            'package_id' => $request->input('package_id'),
            'coach_id' => $request->input('coach_id'),
        ]);
        return redirect('/members')->with('successUp', 'member updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     //
    //     $per = personnel::find($id);
    //     $path1 = public_path('images/profiles/' . $per->per_pic);
    //     if (File::exists($path1)) {
    //         File::delete($path1);
    //     }
    //     personnel::find($id)->delete();
    //     return redirect('/members')->with('successDel', 'member deleted successfully.');
    // }

    public function destroy(string $id)
    {
        //
        $per = personnel::find($id);
        $path1 = public_path('images/profiles/' . $per->per_pic);
        if (File::exists($path1)) {
            File::delete($path1);
        }
        personnel::find($id)->delete();
        // return redirect('/members')->with('successDel', 'member deleted successfully.');
        return response()->json(['success' => true, 'tr' => 'tr_' . $id]);
    }
}
