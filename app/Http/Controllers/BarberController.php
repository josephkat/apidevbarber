<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Barber;
use App\Models\BarberPhotos;
use App\Models\BarberServices;
use App\Models\BarberTestimonial;
use App\Models\BarberAvailability;

class BarberController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
        $this->loggedUser = auth()->user();
    }

    public function createRandom() {
        $array = ['error' => ''];

        for($q=0;$q<15;$q++) {
            $names = ['Joseph', 'Maria', 'Paola', 'Pedro', 'Amanda', 'Leticia', 'Gabriel','Jonathan',
             'Samuel', 'Patricia', 'Raquel', 'Claudia', 'Cassia', 'Samara', 'Samathan', 'Alfredo'];
            $lastnames = ['katiamba', 'Katiamba', 'Katiamba', 'Ramalho', 'Silva', 'Cirqueira', 'Cirqueira','Mpoto',
             'Batista', 'Cirqueira', 'Cirqueira', 'Cirqueira', 'Ramalho', 'Ramalho', 'Ramalho', 'Ramalho'];

            $servicos = ['Corte', 'Pintura', 'Aparação', 'Enfeite'];
            $servicos2 = ['Cabelo', 'Unha', 'Pernas', 'Sobrancelhas'];
            
            $depos = ['Lorem ipsum dolor sit amet', 'consectetur adipiscing elit',
                    'sed do eiusmod tempor incididunt ut labore', 
                    'et dolore magna aliqua', 'Ut enim ad minim veniam'
            ];

            $newBarber = new Barber();
            $newBarber->name = $names[rand(0, count($names)-1)].''.$lastnames[rand(0, count($lastnames)-1)];
            $newBarber->avatar = rand(1, 4).'.png';
            $newBarber->stars = rand(2, 4).'.'.rand(0, 9);
            $newBarber->latitude = '-23.5'.rand(0,9).'30907';
            $newBarber->longitude = '-46.6'.rand(0,9).'82795';
            $newBarber->save();

            $ns = rand(3, 6);

            // gerando fotos aleotorios
            for($w=0;$w<4;$w++) {
                $newBarberPhoto = new BarberPhotos();
                $newBarberPhoto->id_barder = $newBarber->id;
                $newBarberPhoto->url = rand(1,5).'.png';
                $newBarberPhoto->save();
            }

            for($w=0;$w<$ns;$w++) {
                $newBarberService = new BarberService();
                $newBarberService->id_barbder = $newBarber->id;
                $newBarberService->name = $servicos[rand(0, count($servicos)-1)].' de '.$servicos2[rand(0, count($servicos)-1)];
                $newBarberService->price = rand(1, 99).'.'.rand(0, 100);
                $newBarberService->save();
            }

            for($w=0;$w<4;$w++) {
                $newBarberTestimonial = new BarberTestimonial();
                $newBarberTestimonial->id_barber = $newBarber->id;
                $newBarberTestimonial->name = $names[rand(0, count($names)-1)];
                $newBarberTestimonial->rate = rand(2,4).'.'.rand(0,9);
                $newBarberTestimonial->body = $depos[rand(0, count($depos)-1)];
                $newBarberTestimonial->save();
            }

            //gerando Hora aleatória para o Barbeiro
            for($e=0;$e<4;$e++) {
                $rAdd = rand(7, 10);
                $hours = [];
                for($r=0;$r<8;$r++) {
                    $time = $r + $rAdd;
                    if($time < 10) {
                        $time = '0'.$time;
                    }
                    $hours[] = $time.':00';
                }
                $newBarberAvail = new BarberAvailability();
                $newBarberAvail->id_barber = $newBarber->id;
                $newBarberAvail->weekday = $e;
                $newBarberAvail->hours = implode(',', $hours);
                $newBarberAvail->save();
            }
        }

        return $array;
    }
}
