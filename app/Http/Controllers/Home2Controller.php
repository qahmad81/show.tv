<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Episode;
use App\Series;
use App\Restores;
use Storage;
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
        if (!Restores::find(date("Y-m-d"))) $this->restore();

        $ep = new Episode();

        $episodes = $ep->getrand();
        $menuSerieses = Series::take(5)->get();

        return view('home2', compact('episodes', 'menuSerieses'));
    }

    public function restore()
    {
        if (!Restores::find(date("Y-m-d"))) {
            Restores::insert(array("id" => date("Y-m-d") ) );
            Restores::restore();
            $backfiles = Storage::disk('episodes')->files('back');
            $filesKey = array();
            foreach($backfiles as $file) {
                $fileName = (string)Str::of($file)->afterLast('/');
                if (Storage::disk('episodes')->missing($fileName))
                    Storage::disk('episodes')->copy($file, $fileName);
                $filesKey[$fileName] = 1;
            }

            $files = Storage::disk('episodes')->files('.');
            foreach($files as $file) {
                if (!isset($filesKey[$file]))
                    Storage::disk('episodes')->delete($file);
            }
        }
        
        return 'restore done';
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
