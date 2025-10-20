<?php

namespace App\Http\Controllers;

use App\Models\coach;
use App\Models\package;
use App\Models\payment;
use App\Models\personnel;
use App\Models\transformation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class profileController extends Controller
{
    //
    // /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function index()
    {
        $idUser = session()->get('user_id');
        $user = personnel::find($idUser);
        //charts
        //-------------------------------------------------------------------
        $id = session()->get('user_id');
        $subscriptionWeek = DB::table('presences')
            ->select(DB::raw('@subscription_week := WEEK(MIN(created_at))'))
            ->where('personnel_id', $id)
            ->value('subscription_week');
        //dd($subscriptionWeek);
        $results = DB::table('presences')
            ->select(
                DB::raw('WEEK(created_at) - ' . $subscriptionWeek . ' + 1 AS week_number'),
                DB::raw('COUNT(*) AS presence_count')
            )
            ->where('personnel_id', $id)
            ->groupBy('personnel_id', 'week_number')
            ->get()
            ->toArray();
        //fill the gap between the weeks
        //______________________________________________ILA MAKAN HTÁCHI PRESENCE BL ID DYAL KHONA LI DAKHL L PROFIL DYALO ITLA3 LIK ERROR
        if (count($results) != 0) {
            $finalResults = [];
            for ($i = 0; $i < count($results); $i++) {
                $finalResults[] = $results[$i]; // Check if there is a gap between the current and next week numbers
                if ($i < count($results) - 1 && $results[$i]->week_number != ($results[$i + 1]->week_number - 1)) {
                    $missingWeeks = $results[$i + 1]->week_number - $results[$i]->week_number - 1;
                    // Add the missing week numbers with a presence count of 0
                    for ($j = 1; $j <= $missingWeeks; $j++) {
                        $finalResults[] = (object) ['week_number' => $results[$i]->week_number + $j, 'presence_count' => 0];
                    }
                }
            }
            foreach ($finalResults as $row) {
                $weeks[] = $row->week_number;
                $nbrpre[] = $row->presence_count;
            }
            foreach ($weeks as $number) {
                $weekx[] = 'week ' . $number;
            }
        } else {
            //dd('kda');
            $weekx = ['week 1'];
            $nbrpre = [0];
            //dd([$weekx,$nbrpre]);
        }
        //------------------------------------------------------------------- payment tracker
        $daysSincePayment = DB::table('payments')
            ->selectRaw('DATEDIFF(CURDATE(), created_at) AS days_since_payment')
            ->where('personnel_id', $id)
            ->orderBy('created_at', 'DESC')
            ->limit(1)
            ->get()
            ->toArray();

        if (count($daysSincePayment)) {
            $daysSincePayment = $daysSincePayment[0]->days_since_payment;
            $ArrdaysSincePayment[] = $daysSincePayment;
        } else {
            $ArrdaysSincePayment[] = 0;
        }
        //charts
        if($ArrdaysSincePayment[0] >= 30 ){
            $ArrdaysSincePayment[0] = 30 ;
        }
        //dd($user->per_pic);
                $coachs = coach::all();

        return view('users.home', [
            'user' => $user,
            'weekx' => $weekx,
            'nbrpre' => $nbrpre,
            'ArrdaysSincePayment' => $ArrdaysSincePayment,
            'coachs' => $coachs,
        ]);
    }

    public function account()
    {
        $id = session()->get('user_id');
        $user = personnel::find($id);

        //dd($user);
        $packages = package::all();
        $coachs = coach::all();
        return view('users.account', [
            'user' => $user,
            'packages' => $packages,
            'coachs' => $coachs,
        ]);
    }



    // /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function updateUser(Request $request, string $id)
    {
        //dd($request);
        $member = personnel::find($id);
        if($request->hasFile('per_pic')){
                //Save photo in the folder
            $path1 = public_path('images/profiles/' . $member->per_pic);
                if (File::exists($path1)) {
                    File::delete($path1);
                }
            $newImageName = rand(10000, 99999) . '_' . time() . '_' . $request->per_prenom . '.'.$request->per_pic->extension();
            $request->per_pic->move(public_path('images/profiles'), $newImageName);

        }else{
            $newImageName = $request->Old_per_pic;

        }
        personnel::find($id)->update([
            'per_nom' => $request->input('per_nom'),
            'per_prenom' => $request->input('per_prenom'),
            'per_tel' => $request->input('per_tel'),
            'per_sexe' => $request->input('per_sexe'),
            'per_pic' => $newImageName,
            'per_email' => $request->input('per_email'),
            'package_id' => $request->input('package_id'),
            'coach_id' => $request->input('coach_id'),
        ]);
        return redirect('/profile/account')->with('successUp', 'informations updated successfully.');
    }
    // /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function transformation()
    {
        $personnels = personnel::all()->where('per_role', '=', 0);
        $coaches = coach::all();
        $id = session()->get('user_id');
        $user = personnel::find($id);
        $trans = transformation::where('personnel_id','=',$id)->get();
        //-----------------------------------------
        $results = DB::table('transformations AS t')
                ->join('personnels AS m', 't.personnel_id', '=', 'm.id')
                ->selectRaw('WEEK(t.created_at) - WEEK(m.created_at) + 1 AS week_number, MAX(t.tra_poid) AS tra_poid')
                ->where('t.personnel_id', $id)
                ->groupBy('week_number')
                ->orderBy('week_number')
                ->get()
                ->toArray();
                //-----------------------------------------
        if (count($results) != 0) {
            foreach ($results as $row) {
                $weekss[] = $row->week_number;
                $poids[] = intval($row->tra_poid);
            }
            foreach ($weekss as $number) {
                $weekx[] = 'week ' . $number;
            }
            } else {
                $weekx = ['1 week'];
                $poids = [0];
            }
        return view('users.transformation', [
            'trans' => $trans,
            'coaches' => $coaches,
            'personnels' => $personnels,
            'user' => $user,
            'weekx' => $weekx,
            'poids' => $poids,
        ]);
    }
    // //////////////////////////////////////////////////
    public function addTransUser(Request $request, string $id)
    {
        //dd($request);
        $request->validate([
            'tra_description' => 'bail|required|string',
            'tra_pic1' => 'bail|image|mimes:png,jpeg,jpg',
            'tra_poid' => 'bail|required|numeric|required',
            'tra_duree' => 'bail|required|numeric',
            'personnel_id' => 'bail|required|numeric',
        ]);
        /*************************************/
        if($request->HasFile('tra_pic1')){
            $newImageName1 = rand(10000, 99999) . '_' . time() . '_' . $request->tra_duree . '.' .
            $request->tra_pic1->extension();
            // dd($newImageName);
            $request->tra_pic1->move(public_path('images/transformations'), $newImageName1);
            /************************************/
        }else{
            $newImageName1 = "" ;
        }
        transformation::create([
            'tra_description' => $request->input('tra_description'),
            'tra_pic1' => $newImageName1,
            'tra_poid' => $request->input('tra_poid'),
            'tra_duree' => $request->input('tra_duree'),
            'coach_id' => $request->input('coach_id'),
            'personnel_id' => $request->input('personnel_id'),
        ]);
        //dd($transformation);
        return redirect('/profile/transformation')->with('success', 'transfornatiom added successfully.');
    }

    // /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function password()
    {
        $id = session()->get('user_id');
        $user = personnel::find($id);
        return view('users.password', compact('user'));
    }
    // //////////////////////////////////////////////////
    public function updatePassword(Request $request)
    {
        # Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);
        #Match The Old Password
        $id = session()->get('user_id');
        $user = personnel::find($id);
        if (!(Hash::check($request->old_password, $user->per_password))) {
            return back()->with("error", "Old Password Doesn't match!");
        }
        #Update the new Password
        personnel::whereId(session()->get('user_id'))->update([
            'per_password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "Password changed successfully!");
    }
}
