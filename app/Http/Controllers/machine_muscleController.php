<?php

namespace App\Http\Controllers;

use App\Models\machine;
use App\Models\machine_muscle;
use App\Models\muscle;
use App\Models\notification;
use Illuminate\Http\Request;

class machine_muscleController extends Controller
{
    //
    public function assign(string $id){

        $muscle = muscle::find($id);
        //dd($muscle);
        $machines = machine::all();
        $NewUsersnotifications = notification::where('not_type','=','nu')->get();
        $nbrNotifications = notification::all()->count();
        $PayAlertsnotifications = notification::where('not_type','=','pa')->get();

        return view('machine_muscle.assignTomachine',[
            'muscle'=>$muscle,
            'machines'=>$machines,
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
                'muscle_id'=>$request->input('muscle_id'),
                'machine_id'=>$id,
            ]);
        }
        return redirect('/muscles')->with('assign','Records has been assigned successfully !');
    }
}

