<?php

namespace App\Http\Controllers;

use App\Models\payment;
use App\Models\personnel;
use App\Models\notification;
use Illuminate\Http\Request;

class paymentController extends Controller
{
    //
    public function Pre_index(){
        $members = personnel::where('per_role','=',0)->orderBy('created_at','desc')->paginate(7);
        $NewUsersnotifications = notification::where('not_type','=','nu')->get();
        $nbrNotifications = notification::all()->count();
        $PayAlertsnotifications = notification::where('not_type','=','pa')->get();

        return view('payment.Pre_index',[
        'members'=>$members,
        'nbrNotifications'=>$nbrNotifications,
        'NewUsersnotifications'=>$NewUsersnotifications,
        'PayAlertsnotifications'=>$PayAlertsnotifications,

        ]);
    }
    public function index(string $id){
        //dd($id);
        $member = personnel::find($id);
        $NewUsersnotifications = notification::where('not_type','=','nu')->get();
        $nbrNotifications = notification::all()->count();
        $payments = $member->payments;
        $PayAlertsnotifications = notification::where('not_type','=','pa')->get();

        if(count($payments)){
            return view('payment.index',[
                'payments'=>$payments,
                'memberId'=>$member->id,
                'member'=>$member,
                'nbrNotifications'=>$nbrNotifications,
                'NewUsersnotifications'=>$NewUsersnotifications,
                'PayAlertsnotifications'=>$PayAlertsnotifications,

            ]);
        }else{
            return view('payment.create',[
                'memberId'=>$member->id,
                'nbrNotifications'=>$nbrNotifications,
                'NewUsersnotifications'=>$NewUsersnotifications,
                'PayAlertsnotifications'=>$PayAlertsnotifications,
            ])->with('none','this member has no payments !');
        }
    }
    public function create(string $id){
        $memberId = $id;
        $NewUsersnotifications = notification::where('not_type','=','nu')->get();
        $nbrNotifications = notification::all()->count();
        $PayAlertsnotifications = notification::where('not_type','=','pa')->get();

        return view('payment.create',[
            'memberId'=>$memberId,
            'nbrNotifications'=>$nbrNotifications,
            'NewUsersnotifications'=>$NewUsersnotifications,
            'PayAlertsnotifications'=>$PayAlertsnotifications,

        ]); 
    }
    public function store(Request $request){
        //dd($request);
        $request->validate([
            'pay_date'=>'bail|required|date',
            'personnel_id'=>'bail|required|numeric',
        ]);
        payment::create([
            'pay_date'=>$request->input('pay_date'),
            'personnel_id'=>$request->input('personnel_id'),
        ]);
        return redirect('/payments/'.$request->input('personnel_id'))->with('success','Payment added successfuly !');
    }
    public function destroy(Request $re , string $id){
        $payment = payment::find($id);
        $payment->delete();
        return redirect('/payments/'.$re->idx)->with('successDel','Payment has been deleted successfuly !');
    }
}
