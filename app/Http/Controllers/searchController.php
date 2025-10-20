<?php

namespace App\Http\Controllers;

use App\Models\coach;
use App\Models\machine;
use App\Models\muscle;
use App\Models\package;
use App\Models\personnel;
use App\Models\transformation;
use Illuminate\Http\Request;

class searchController extends Controller
{

    public function searchCoache(Request $req)
    {
        $req->validate([
            'search' => ['required'],
        ]);
        $q = $req->search;
        $filteredCoache = coach::where('coa_nom', 'like', '%' . $q . '%')
            ->orWhere('coa_email', 'like', '%' . $q . '%')
            ->orWhere('coa_prenom', 'like', '%' . $q . '%')
            ->paginate();
        if ($filteredCoache->count()) {
            return view('coache.index', [
                'coaches' => $filteredCoache
            ]);
        } else {
            return redirect('/coaches')->with('mnf', 'coache not found.');
        }
    }
    // //////////////////////////////////////////////////////////////////////////////

    public function searchMember(Request $req)
    {
        $req->validate([
            'search' => ['required'],
        ]);
        $q = $req->search;
        $packages = package::all();
        $coaches = coach::all();
        $filteredMember = personnel::where('per_role', '=', 0)
            ->where('per_nom', 'like', '%' . $q . '%')
            ->orWhere('per_email', 'like', '%' . $q . '%')
            ->orWhere('per_prenom', 'like', '%' . $q . '%')
            ->paginate();
        if ($filteredMember->count()) {
            return view('members.index', [
                'members' => $filteredMember,
                'packages' => $packages,
                'coaches' => $coaches,
            ]);
        } else {
            return redirect('/members')->with('mnf', 'coache not found.');
        }
    }
    // //////////////////////////////////////////////////////////////////////////////
    public function searchTrans(Request $req)
    {
        $req->validate([
            'search' => ['required'],
        ]);
        $q = $req->search;
        $coaches = coach::all();
        $personnels = personnel::all()->where('per_role', '=', 0);
        $filteredTrans = transformation::where('tra_description', 'like', '%' . $q . '%')->paginate();
        if ($filteredTrans->count()) {
            return view('transformation.index', [
                'trans' => $filteredTrans,
                'coaches' => $coaches,
                'personnels' => $personnels,
            ]);
        } else {
            return redirect('/transformations')->with('mnf', 'transformation not found.');
        }
    }
    // //////////////////////////////////////////////////////////////////////////////

    public function searchPack(Request $req)
    {
        $req->validate([
            'search' => ['required'],
        ]);
        $q = $req->search;
        $filteredPack = package::where('pac_title', 'like', '%' . $q . '%')
            ->orWhere('pac_description', 'like', '%' . $q . '%')
            ->orWhere('pac_prix', 'like', '%' . $q . '%')
            ->paginate();
        if ($filteredPack->count()) {
            return view('package.index', [
                'packages' => $filteredPack
            ]);
        } else {
            return redirect('/packages')->with('mnf', 'package not found.');
        }
    }

    // //////////////////////////////////////////////////////////////////////////////

    public function searchMusc(Request $req)
    {
        $req->validate([
            'search' => ['required'],
        ]);
        $q = $req->search;
        $filteredMusc = muscle::where('mus_label', 'like', '%' . $q . '%')->paginate();
        if ($filteredMusc->count()) {
            return view('muscle.index', [
                'muscles' => $filteredMusc
            ]);
        } else {
            return redirect('/muscles')->with('mnf', 'muscle not found.');
        }
    }
    // //////////////////////////////////////////////////////////////////////////////

    public function searchMach(Request $req)
    {
        $req->validate([
            'search' => ['required'],
        ]);
        $q = $req->search;
        $filteredMach = machine::where('mac_label', 'like', '%' . $q . '%')
            ->orWhere('mac_description', 'like', '%' . $q . '%')
            ->orWhere('mac_matricule', 'like', '%' . $q . '%')
            ->paginate();
        if ($filteredMach->count()) {
            return view('machine.index', [
                'machines' => $filteredMach
            ]);
        } else {
            return redirect('/machines')->with('mnf', 'machine not found.');
        }
    }
    // //////////////////////////////////////////////////////////////////////////////

    public function searchPay(Request $req)
    {
        $req->validate([
            'search' => ['required'],
        ]);
        $q = $req->search;
        $filteredPay = personnel::where('per_prenom', 'like', '%' . $q . '%')
            ->orWhere('per_nom', 'like', '%' . $q . '%')
            ->orWhere('per_email', 'like', '%' . $q . '%')
            ->orWhere('per_status', 'like', '%' . $q . '%')
            ->paginate();
        if ($filteredPay->count()) {
            return view('payment.Pre_index', [
                'members' => $filteredPay
            ]);
        } else {
            return redirect('/payments')->with('mnf', 'payement not found.');
        }
    }
}
