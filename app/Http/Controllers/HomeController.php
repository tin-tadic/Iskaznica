<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Card;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{

    public function getUsers(Request $request) {

        $searchBy = $request->searchParametersUser;
        $searchFor = $request->input('home-searchFor');

        switch($searchBy) {
            
            case "user-byName":
                $users = User::where('name', $searchFor)->orWhere('name', 'like', '%' . $searchFor . '%')->get();
                if (sizeof($users) > 0) {
                    return redirect()->route('home')->with('users', $users);
                }
                return redirect()->route('home')->with('warning', 'Nisu pronađeni korisnici sa takvim ili sličnim imenom.');
            
             case "user-byEmail":
                $users = User::where('email', $searchFor)->orWhere('email', 'like', '%' . $searchFor . '%')->get();
                if (sizeof($users) > 0) {
                    return redirect()->route('home')->with('users', $users);
                }
                return redirect()->route('home')->with('warning', 'Nisu pronađeni korisnici sa takvim ili sličnim emailom.');
            
            case "user-byRole":
                if(is_numeric($searchFor) && $searchFor >=0 && $searchFor < 3) {
                    $users = User::where('role', $searchFor)->get();
                    if (sizeof($users) > 0) {
                        return redirect()->route('home')->with('users', $users);
                    }
                    return redirect()->route('home')->with('warning', 'Nisu pronađeni korisnici sa tim ovlastima.');
                } else {
                    return redirect()->back()->withInput()->with('error', 'Za pretragu po ovlastima unesite broj od 0 do 2!');
                }
            
            
            case "card-byName":
                if(strlen($searchFor) >= 2) {

                    if($request->searchForDeletedCards) {
                        $cards = Card::where('ime_prezime', $searchFor)->orWhere('ime_prezime', 'like', '%' . $searchFor . '%')->withTrashed()->get();
                    } else {
                        $cards = Card::where('ime_prezime', $searchFor)->orWhere('ime_prezime', 'like', '%' . $searchFor . '%')->get();
                    }

                    if (sizeof($cards) > 0) {
                        foreach($cards as $card) {
                            $card->vazi_do = Carbon::parse($card->vazi_do)->format('d/m/y');
                        }
                        return redirect()->route('home')->with('cards', $cards);
                    } else {
                        return redirect()->back()->withInput()->with('warning', 'Nisu pronađene iskaznice sa tim imenom!');
                    }
                } else {
                    return redirect()->back()->withInput()->with('error', 'Unesite minimalno 2 znaka za pretragu iskaznica po imenu!');
                }
            
            case "card-byNumber":
                if (is_numeric($searchFor)) {
                    // Has to be `get()` because that's the type of response the frontend expects
                    if($request->searchForDeletedCards) {
                        $cards = Card::where('id', $searchFor)->withTrashed()->get();
                    } else {
                        $cards = Card::where('id', $searchFor)->get();
                    }

                    if (sizeof($cards) > 0) {
                        $cards[0]->vazi_do = Carbon::parse($cards[0]->vazi_do)->format('d/m/y');
                        return redirect()->route('home')->with('cards', $cards);
                    } else {
                        return redirect()->back()->withInput()->with('warning', 'Iskaznica ne postoji ili je obrisana!');
                    }
                }
                return redirect()->back()->withInput()->with('error', 'Unesite broj za pretragu po broju iskaznice!');
        
            case "card-byUuid":
                if (strlen($searchFor) == 36) {

                    if($request->searchForDeletedCards) {
                        $cards = Card::where('ID_iskaznice', $searchFor)->withTrashed()->get();
                    } else {
                        $cards = Card::where('ID_iskaznice', $searchFor)->get();
                    }
                    if (sizeof($cards) > 0) {
                        return redirect()->back()->with('cards', $cards);
                    } else {
                        return redirect()->back()->withInput()->with('warning', 'Iskaznica ne postoji ili je obrisana!');
                    }
                    
                } else {
                    return redirect()->back()->withInput()->with('error', 'Neispravan oblik ID-a!');
                }
            
            case "card-byAddedBy":
                if(strlen($searchFor) > 0 && is_numeric($searchFor)) {
                    if($request->searchForDeletedCards) {
                        $cards = Card::where('dodao_korisnik', $searchFor)->withTrashed()->get();
                    } else {
                        $cards = Card::where('dodao_korisnik', $searchFor)->get();
                    }
                    
                    if (sizeof($cards) > 0) {
                        return redirect()->back()->with('cards', $cards);
                    } else {
                        return redirect()->back()->withInput()->with('warning', 'Iskaznica ne postoji ili je obrisana!');
                    }
                } else {
                    return redirect()->back()->withInput()->with('error', 'Unesite broj za pretragu po IDu korisnika!');
                }

            default:
                return redirect()->route('home')->with('error', 'Neispravni parametri pretrage!');
        }

    }

    public function getUserForEdit($userId) {
        $user = User::where('id', $userId)->first();
        return view('editUser')->with('user', $user);
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

}
