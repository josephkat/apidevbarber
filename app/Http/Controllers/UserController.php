<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\UserFavorite;

class UserController extends Controller
{
    private $loggedUser;

    public function __construct() {
        $this->middleware('auth:api');
        $this->loggedUser = auth()->user();
    }
    public function toggleFavorite(Request $request) {
        $array = ['error' => ''];

        $id_barber = $request->input('barber');

        $barber = Barber::find($id_barber);

        if($barber) {
            $fav = UserFavorite::select()
                ->where('id_user', $this->loggedUser->id)
                ->where('id_barber', $id_barber)
            ->first();

            if($fav) {
                // remove
                $fav->delete();
                $array['have'] = false;
            } else {
                // adicionar
                $newFav = new UserFavorite();
                $newFav->id_user = $this->loggedUser->id;
                $newFav->id_barber = $id_barber;
                $newFav->save();
                $array['have'] = true;
            }
        } else {
            $array['error'] = 'Barbeiro inexistente';
        }
        return $array;
    }

    public function getFavorites() {
        $array = ['error' => '', 'list'=>[]];

        $favs = UserFavorite::select()
            ->where('id_user', $this->loggedUser->id)
            ->get();
        
        if($favs) {
            foreach($favs as $fav) {
                $barber = Barber::find($fav['id_barber']);
                $array['list'][] = $barber;
            }
        }

        return $array;
    }
}
