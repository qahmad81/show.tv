<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Episode;
use App\Series;
use DB;
class Home2Controller extends Controller
{
    /**
     * Show the Episodes in home page.
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

    /**
     * Search Episodes in home page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $searchword = $request->search;

        $episodes = Episode::where('title', 'like', '%'.$searchword.'%')
                            ->orWhere('description', 'like', '%'.$searchword.'%')
                            //->orWhere('series.title', 'like', '%'.$searchword.'%')
                            ->take(10)->get();

        $menuSerieses = Series::take(5)->get();


        return view('home2', compact('episodes', 'menuSerieses', 'searchword'));
    }

}
