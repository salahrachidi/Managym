<?php

namespace App\Http\Controllers;

use App\Models\machine;
use App\Models\machine_muscle;
use App\Models\muscle;
use App\Models\notification;
use Illuminate\Http\Request;

class muscle_machineController extends Controller
{
    //
    public function assign(string $id){

        $machine = machine::find($id);
        //dd($muscle);
        $muscles = muscle::all();
        $NewUsersnotifications = notification::where('not_type','=','nu')->get();
        $nbrNotifications = notification::all()->count();
        $PayAlertsnotifications = notification::where('not_type','=','pa')->get();

        return view('machine_muscle.assignTomuscle',[
                'machine'=>$machine,
                'muscles'=>$muscles,
                'nbrNotifications'=>$nbrNotifications,
                'NewUsersnotifications'=>$NewUsersnotifications,
                'PayAlertsnotifications'=>$PayAlertsnotifications,

        ]);
    }
    public function store(Request $request){

        $machines = $request->machines;
        //dd($machinesArray);
        foreach ($machines as $id){
        machine_muscle::create([
                'machine_id'=>$request->input('machine_id'),
                'muscle_id'=>$id,
        ]);
        }
        return redirect('/machines')->with('assign','Records has been assigned successfully !');
    }
}
