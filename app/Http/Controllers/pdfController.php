<?php

namespace App\Http\Controllers;

use App\Models\personnel;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class pdfController extends Controller
{
    //
    public function PDf(String $id){
        $user = personnel::find($id);
            $controleQR = "Member's full name : ".' '.$user->per_nom.'_'.$user->per_prenom . PHP_EOL
                ."Member's Subscription price : ".' '.$user->package->pac_prix.PHP_EOL.' dh'
                ."Member's Phone Number :".' '.$user->per_tel.PHP_EOL
                ."Member's id :".' '.$user->id
                ."Member's inscription date :".' '.$user->created_at;
            $qr = QrCode::size(200)
                ->color(223, 169, 122)
                ->margin(1)
                ->generate(
                $controleQR,
                );
            return view('receipt',[
                'user'=>$user,
                'qr'=>$qr
            ]);
    }
}
