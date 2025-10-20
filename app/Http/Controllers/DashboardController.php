<?php

namespace App\Http\Controllers;

use App\Models\coach;
use App\Models\machine;
use App\Models\notification;
use App\Models\package;
use App\Models\payment;
use App\Models\personnel;
use App\Models\presence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        //charts
        $members = personnel::where('per_role','=','0')->count();
        $coaches = coach::all()->count();
        $machines = machine::all()->count();
        $recentMembers = Personnel::orderBy('created_at', 'desc')
                                    ->where('per_status', 0)
                                    ->take(10)
                                    ->get();
        //dd($recentMembers);
        //-------------------------------------------------------------------------
        $result = DB::table('personnels')
        ->join('packages', 'personnels.package_id', '=', 'packages.id')
        ->select('packages.pac_title', DB::raw('COUNT(personnels.id) as member_count'))
        ->groupBy('packages.pac_title')
        ->get()
        ->toArray();
        if( count($result) ){
            foreach ($result as $row) {
                //dd($row);
                $packages[] = $row->pac_title;
                $membersArray[] = $row->member_count;
            }
        }else{
            $packages[] =['none','none','none'];
            $membersArray[] = [0,0,0];
        }
        //+++++++
        $result = DB::table('personnels')
        ->select(DB::raw("DATE_FORMAT(created_at, '%m') AS month"), DB::raw('COUNT(*) AS member_count'))
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->toArray();
        if( count($result) ){
            foreach ($result as $row) {
                //dd($row);
                $mounths[] = intval($row->month);
                $mPm[] = $row->member_count;
            }
            //convert an array of integer values to string months
            foreach ($mounths as $month) {
                $monthName = date('F', mktime(0, 0, 0, $month, 1));
                $monthNames[] = $monthName;
            }
        }else{
            $monthName[] = ['none','none','none'] ;
            $mPm = [0,0,0];
        }
        //convert an array of integer values to string months
        //+++++++
        $result = DB::table('personnels')
        ->select(DB::raw("DATE_FORMAT(created_at, '%Y') AS year"), DB::raw('COUNT(*) AS member_count'))
        ->groupBy('year')
        ->orderBy('year')
        ->get()
        ->toArray();
        if( count($result ) ){
            foreach ($result as $row) {
                $years[] = intval($row->year);
                $mPY[] = $row->member_count;
            }
        }else{
            $years[] = [2022,2023,2024];
            $mPY[] = [123,241,431];
        }
        //+++++++
        $a = personnel::where('per_status', '=', '1')
        ->where('per_role', '=', '0')
        ->get()->count();
        $i = personnel::where('per_status', '=', '0')
        ->where('per_role', '=', '0')
        ->get()->count();
        $status = [];
        array_push($status,$a);
        array_push($status,$i);
        //+++++++
        $H = personnel::where('per_sexe', '=', 'H')
        ->where('per_role', '=', '0')
        ->get()->count();
        $F = personnel::where('per_sexe', '=', 'F')
        ->where('per_role', '=', '0')
        ->get()->count();
        $Sexe = [];
        array_push($Sexe,$H);
        array_push($Sexe,$F);
        //charts
        $role = session()->get('user_role');
        $NewUsersnotifications = notification::where('not_type','=','nu')->get();
        $nbrNotifications = notification::all()->count();
        $PayAlertsnotifications = notification::where('not_type','=','pa')->get();
        $packs = package::all()->count();
        //------------------------------------------------Presences
        $personnelPresentToday = personnel::whereHas('presences', function ($query) {
        $query->whereDate('created_at', '=', now()->toDateString());
        })->get();
        $personnelIds = Personnel::whereHas('presences', function ($query) {
                $query->whereDate('created_at', now()->toDateString());
        })->pluck('id')->toArray();
        
        $daysLeftArray = [];
        foreach ($personnelIds as $personnelId) {
                $payment = Payment::where('personnel_id', $personnelId)
                                    ->orderBy('created_at', 'desc')
                                    ->first();

        $daysLeft = null;
        if ($payment) {
                $lastPaymentDate = $payment->created_at;
                $expirationDate = $lastPaymentDate->addDays(30);
                $daysLeft = now()->diffInDays($expirationDate);
        }

        $daysLeftArray[$personnelId] = $daysLeft;
        }
        return view('dashboard.dash', [
            'members' => $members,
            'coaches'=>$coaches,
            'machines'=>$machines,
            'packages'=>$packages,
            'membersArray'=>$membersArray,
            'monthNames'=>$monthNames,
            'mPm'=>$mPm,
            'years'=>$years,
            'mPY'=>$mPY,
            'status'=>$status,
            'Sexe'=>$Sexe,
            'recentMembers'=>$recentMembers,
            'nbrNotifications'=>$nbrNotifications,
            'NewUsersnotifications'=>$NewUsersnotifications,
            'PayAlertsnotifications'=>$PayAlertsnotifications,
            'packs'=>$packs,
            'personnelPresentToday'=>$personnelPresentToday,
            'daysLeftArray'=>$daysLeftArray,
        ]);
    }
}
