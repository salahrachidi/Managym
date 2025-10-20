<?php

namespace App\Http\Controllers;

use App\Models\notification;
use Illuminate\Http\Request;

class NotifiactionsController extends Controller
{
    public function destroy(String $id){

        notification::findOrFail($id)->delete();
        return redirect()->back();
    }
    public function clearAll(){
        // dd('kda');
        notification::where('not_type','=','nu')->delete();
        return redirect()->back();
    }
    public function clearpa(){
        notification::where('not_type','=','pa')->delete();
        return redirect()->back();
    }

}
