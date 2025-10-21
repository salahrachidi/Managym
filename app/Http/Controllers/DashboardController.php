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
        // -------- Static demo data (no DB) to render dashboard for screenshots --------

        // High-level counts
        $members  = 128;   // total members (per_role=0)
        $coaches  = 6;     // total coaches
        $machines = 24;    // total machines

        // Recent members (mock objects with typical fields)
        $recentMembers = collect([
            (object)[ 'id'=>101, 'per_nom'=>'Ait',   'per_prenom'=>'Youssef',   'per_status'=>0, 'created_at'=>now()->subDays(1) ],
            (object)[ 'id'=>102, 'per_nom'=>'Ben',   'per_prenom'=>'Mouna',     'per_status'=>0, 'created_at'=>now()->subDays(2) ],
            (object)[ 'id'=>103, 'per_nom'=>'Karim', 'per_prenom'=>'Imane',     'per_status'=>0, 'created_at'=>now()->subDays(3) ],
            (object)[ 'id'=>104, 'per_nom'=>'Said',  'per_prenom'=>'Mehdi',     'per_status'=>0, 'created_at'=>now()->subDays(4) ],
            (object)[ 'id'=>105, 'per_nom'=>'Ali',   'per_prenom'=>'Salma',     'per_status'=>0, 'created_at'=>now()->subDays(5) ],
            (object)[ 'id'=>106, 'per_nom'=>'Rach',  'per_prenom'=>'Aya',       'per_status'=>0, 'created_at'=>now()->subDays(6) ],
            (object)[ 'id'=>107, 'per_nom'=>'Ibn',   'per_prenom'=>'Hamza',     'per_status'=>0, 'created_at'=>now()->subDays(7) ],
            (object)[ 'id'=>108, 'per_nom'=>'Omar',  'per_prenom'=>'Hajar',     'per_status'=>0, 'created_at'=>now()->subDays(8) ],
            (object)[ 'id'=>109, 'per_nom'=>'Naji',  'per_prenom'=>'Sara',      'per_status'=>0, 'created_at'=>now()->subDays(9) ],
            (object)[ 'id'=>110, 'per_nom'=>'Fajr',  'per_prenom'=>'Rayan',     'per_status'=>0, 'created_at'=>now()->subDays(10) ],
        ]);

        // Members per package (chart)
        $packages      = ['Basic', 'Pro', 'Elite'];
        $membersArray  = [64, 44, 20];

        // Members per month (chart)
        $monthNames = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        $mPm        = [5,9,12,8,11,6,10,13,7,9,8,10];

        // Members per year (chart)
        $years = [2023, 2024, 2025];
        $mPY   = [86, 124, 128];

        // Active vs Inactive members (status donut)
        $status = [98, 30]; // [active, inactive]

        // Sex distribution (H/F)
        $Sexe = [78, 50];   // [H, F]

        // Notifications (mock collections + counters)
        $NewUsersnotifications  = collect([
            (object)['id'=>1, 'not_type'=>'nu', 'message'=>'New member registered: Aya'],
            (object)['id'=>2, 'not_type'=>'nu', 'message'=>'New member registered: Rayan'],
        ]);
        $PayAlertsnotifications = collect([
            (object)['id'=>3, 'not_type'=>'pa', 'message'=>'Payment due: Member #101'],
        ]);
        $nbrNotifications = $NewUsersnotifications->count() + $PayAlertsnotifications->count();
        $packs = count($packages);

        // Present today (list of personnel objects used by the view)
        $personnelPresentToday = collect([
            (object)[ 'id'=>101, 'per_nom'=>'Ait',   'per_prenom'=>'Youssef' ],
            (object)[ 'id'=>103, 'per_nom'=>'Karim', 'per_prenom'=>'Imane'   ],
            (object)[ 'id'=>105, 'per_nom'=>'Ali',   'per_prenom'=>'Salma'   ],
        ]);

        // Days left array keyed by personnel id (e.g., for payment expiration badges)
        $daysLeftArray = [
            101 => 18,
            103 => 7,
            105 => 3,
        ];

        // Optional: role from session (kept as-is; safe if null)
        $role = session()->get('user_role');

        return view('dashboard.dash', [
            'members'                 => $members,
            'coaches'                 => $coaches,
            'machines'                => $machines,
            'packages'                => $packages,
            'membersArray'            => $membersArray,
            'monthNames'              => $monthNames,
            'mPm'                     => $mPm,
            'years'                   => $years,
            'mPY'                     => $mPY,
            'status'                  => $status,
            'Sexe'                    => $Sexe,
            'recentMembers'           => $recentMembers,
            'nbrNotifications'        => $nbrNotifications,
            'NewUsersnotifications'    => $NewUsersnotifications,
            'PayAlertsnotifications'   => $PayAlertsnotifications,
            'packs'                   => $packs,
            'personnelPresentToday'   => $personnelPresentToday,
            'daysLeftArray'           => $daysLeftArray,
        ]);
    }
}
