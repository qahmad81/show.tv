<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Episode;
use App\Series;
use DB;
class Home2Controller extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $ep = new Episode();

        $episodes = $ep->getrand();
        $menuSerieses = Series::take(5)->get();


        return view('home2', compact('episodes', 'menuSerieses'));
    }
}
