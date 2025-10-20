<?php

namespace App\Http\Controllers;

use App\Models\machine;
use App\Models\notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class machineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $machines = machine::OrderBy('created_at','desc')->paginate(7);
        $NewUsersnotifications = notification::where('not_type','=','nu')->get();
        $nbrNotifications = notification::all()->count();
        $PayAlertsnotifications = notification::where('not_type','=','pa')->get();

        return view('machine.index',[
                'machines'=>$machines,
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

        return view('machine.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'mac_label'=>'bail|required|string',
            'mac_description'=>'bail|required|string',
            'mac_pic'=>'bail|required|image',
            'mac_matricule'=>'bail|required|string',
        ]);

        if ($request->hasFile('mac_pic')) {
            //Save photo in the folder
            $newImageName = rand(10000, 99999) . '_' . time() . '_' . $request->mac_label . '.' .
            $request->mac_pic->extension();
            // dd($newImageName);
            $request->mac_pic->move(public_path('images/machines'), $newImageName);
        }

        machine::create([
            'mac_label'=>$request->input('mac_label'),
            'mac_description'=>$request->input('mac_description'),
            'mac_pic'=>$newImageName,
            'mac_matricule'=>$request->input('mac_matricule'),
        ]);
        return redirect('/machines')->with('success', 'machine added successfully.');;
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
        $machine = machine::find($id);
        $oldPhoto = $machine->mac_pic;
        //dd($machine);
        $NewUsersnotifications = notification::where('not_type','=','nu')->get();
        $nbrNotifications = notification::all()->count();
        $PayAlertsnotifications = notification::where('not_type','=','pa')->get();

        return view('machine.edit',[
            'machine'=>$machine,
            'oldPhoto' =>$oldPhoto,
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
                'mac_label'=>'bail|required|string',
                'mac_description'=>'bail|required|string',
                'mac_pic'=>'bail|image',
                'mac_matricule'=>'bail|required|string',
        ]);
        $machine = machine::find($id);
                //dd($machine->coa_pic);
        if($request->mac_pic == null){
            $newImageName = $request->oldPhoto;
                //dd($newImageName);
        }else{
            $path1 = public_path('images/machines/' . $machine->mac_pic);
            if (File::exists($path1)) {
                File::delete($path1);
            }
            /*****************************************************************/
            //Save photo in the folder
            $newImageName = rand(10000, 99999) . '_' . time() . '_' . $request->mac_label . '.' .
            $request->mac_pic->extension();
            // dd($newImageName);
            $request->mac_pic->move(public_path('images/machines'), $newImageName);
            /*****************************************************************/
        }
        machine::find($id)->update([
                'mac_label'=>$request->input('mac_label'),
                'mac_description'=>$request->input('mac_description'),
                'mac_pic'=>$newImageName,
                'mac_matricule'=>$request->input('mac_matricule'),
        ]);
        return redirect('/machines')->with('successUp', 'machine updated successfully.');;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $mac = machine::find($id);
        $path1 = public_path('images/machines/' . $mac->mac_pic);
        if (File::exists($path1)) {
        File::delete($path1);
        }
        machine::find($id)->delete();
        return redirect('/machines')->with('successDel', 'machine deleted successfully.');
    }
}
