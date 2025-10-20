<?php

namespace App\Http\Controllers;

use App\Models\coach;
use App\Models\notification;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class coacheController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coaches = coach::OrderBy('created_at','desc')->paginate(6);
        $NewUsersnotifications = notification::where('not_type','=','nu')->get();
        $nbrNotifications = notification::all()->count();
        $PayAlertsnotifications = notification::where('not_type','=','pa')->get();

        return view('coache.index', [
            'coaches' => $coaches,
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

        return view('coache.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'coa_nom' => 'bail|required|string',
            'coa_prenom' => 'bail|required|string',
            'coa_tele' => 'bail|required',
            'coa_pic' => ['image', 'mimes:png,jpg,jpeg,svg', 'max:10240'],
            'coa_email' => 'bail|required|email',
        ]);
        /*****************************************************************/
        if ($request->hasFile('coa_pic')) {
            //Save photo in the folder
            $newImageName = rand(10000, 99999) . '_' . time() . '_' . $request->coa_tele . '.' . $request->coa_pic->extension();
            // dd($newImageName);
            $request->coa_pic->move(public_path('images/coaches'), $newImageName);
        }

        /*****************************************************************/
        // coach::create([
        //     'coa_nom' => $request->input('coa_nom'),
        //     'coa_prenom' => $request->input('coa_prenom'),
        //     'coa_tele' => $request->input('coa_tele'),
        //     'coa_pic' => $newImageName,
        //     'coa_email' => $request->input('coa_email'),
        // ]);
        $createNewCoa = new coach();
        $createNewCoa->coa_nom = $request->coa_nom;
        $createNewCoa->coa_prenom = $request->coa_prenom;
        $createNewCoa->coa_tele = $request->coa_tele;
        $createNewCoa->coa_email = $request->coa_email;
        if ($request->hasFile('coa_pic')) {
            $createNewCoa->coa_pic = $newImageName;
        }
        $createNewCoa->save();

        return redirect('/coaches')->with('success', 'coach added successfully.');
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
        $coache = coach::find($id);
        $Oldpic = $coache->coa_pic;
        $NewUsersnotifications = notification::where('not_type','=','nu')->get();
        $nbrNotifications = notification::all()->count();
        $PayAlertsnotifications = notification::where('not_type','=','pa')->get();

        //dd($Oldpic);
        return view('coache.edit', [
            'coache' => $coache,
            'Oldpic'=>$Oldpic,
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
        //dd($request);
        $request->validate([
            'coa_nom' => 'bail|required|string',
            'coa_prenom' => 'bail|required|string',
            'coa_tele' => 'bail|required',
            'coa_pic' => ['image', 'mimes:png,jpg,jpeg,svg', 'max:10240'],
            'coa_email' => 'bail|required|email',
        ]);
        $coache = coach::find($id);
        //dd($coache->coa_pic);
        if($request->coa_pic == null){
            $newImageName = $request->Oldpic;
            //dd($newImageName);
        }else{
            $path1 = public_path('images/coaches/' . $coache->coa_pic);
            if (File::exists($path1)) {
                File::delete($path1);
            }
            /*****************************************************************/
            //Save photo in the folder
            $newImageName = rand(10000, 99999) . '_' . time() . '_' . $request->coa_prenom . '.' .
            $request->coa_pic->extension();
            // dd($newImageName);
            $request->coa_pic->move(public_path('images/coaches'), $newImageName);
            /*****************************************************************/
        }
        $coache->coa_nom = $request->coa_nom;
        $coache->coa_prenom = $request->coa_prenom;
        $coache->coa_tele = $request->coa_tele;
        $coache->coa_email = $request->coa_email;
        if ($request->hasFile('coa_pic')) {
            $coache->coa_pic = $newImageName;
        }
        $coache->save();

        return redirect('/coaches')->with('successUp', 'coache updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $coa = coach::find($id);
        $path1 = public_path('images/coaches/' . $coa->coa_pic);
        if (File::exists($path1)) {
            File::delete($path1);
        }
        coach::find($id)->delete();
        return redirect('/coaches')->with('successDel', 'coache deleted successfully.');
    }
}
