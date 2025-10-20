<?php

namespace App\Http\Controllers;

use App\Models\notification;
use Illuminate\Support\Facades\File;
use App\Models\muscle;
use Illuminate\Http\Request;

class muscleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $NewUsersnotifications = notification::where('not_type','=','nu')->get();
        $nbrNotifications = notification::all()->count();
        $muscles = muscle::OrderBy('created_at','desc')->paginate(7);
        $PayAlertsnotifications = notification::where('not_type','=','pa')->get();

        return view('muscle.index',[
            'muscles'=>$muscles,
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

        return view('muscle.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'mus_label'=>'bail|required|string',
            'mus_pic'=>'bail|required|image|mimes:png,jpg,jpeg,svg|max:10240',
        ]);
        if ($request->hasFile('mus_pic')) {
            //Save photo in the folder
            $newImageName = rand(10000, 99999) . '_' . time() . '_' . $request->mus_label . '.' .
            $request->mus_pic->extension();
            // dd($newImageName);
            $request->mus_pic->move(public_path('images/muscles'), $newImageName);
        }
        muscle::create([
            'mus_label'=>$request->input('mus_label'),
            'mus_pic'=>$newImageName,
        ]);
        return redirect('/muscles')->with('success', 'muscle added successfully.');

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
        $muscle = muscle::find($id);
        $old_photo = $muscle->mus_pic;
        $NewUsersnotifications = notification::where('not_type','=','nu')->get();
        $nbrNotifications = notification::all()->count();
        $PayAlertsnotifications = notification::where('not_type','=','pa')->get();

        return view('muscle.edit',[
            'muscle'=>$muscle,
            'old_photo'=>$old_photo,
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
            'mus_label'=>'bail|required|string',
            'mus_pic'=>'bail|image|mimes:png,jpg,jpeg,svg|max:10240',
        ]);
        $muscle = muscle::find($id);
                //dd($muscle->coa_pic);
        if($request->mus_pic == null){
            $newImageName = $request->old_photo;
                //dd($newImageName);
        }else{
            $path1 = public_path('images/muscles/' . $muscle->mus_pic);
            if (File::exists($path1)) {
                    File::delete($path1);
            }
        /*****************************************************************/
        //Save photo in the folder
        $newImageName = rand(10000, 99999) . '_' . time() . '_' . $request->mus_label . '.'
        .$request->mus_pic->extension();
                // dd($newImageName);
        $request->mus_pic->move(public_path('images/muscles'), $newImageName);
        /*****************************************************************/
        }
        muscle::find($id)->update([
            'mus_label'=>$request->input('mus_label'),
            'mus_pic'=>$newImageName,
        ]);
        return redirect('/muscles')->with('successUp', 'muscle updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $muscle = muscle::find($id);
        $path1 = public_path('images/muscles/' . $muscle->mus_pic);
        if (File::exists($path1)) {
            File::delete($path1);
        }
        muscle::find($id)->delete();
        return redirect('/muscles')->with('successDel', 'muscle deleted successfully.');;
    }
}
