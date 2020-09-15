<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Series;
use App\Follow;

/**
 * Class SeriesController
 * @package App\Http\Controllers
 */
class SeriesController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!$this->isAdmin()) return $this->noPerm();
        $serieses = Series::paginate();
        return view('series.index', compact('serieses'))
            ->with('i', (request()->input('page', 1) - 1) * $serieses->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!$this->isAdmin()) return $this->noPerm();
        return view('series/vadd')->with('submiturl', route('series.store')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$this->isAdmin()) die('No Permission');
        $request->validate(Series::$rules);

        $series = new Series();
        $series->title = $request['title'];
        $series->description = $request['description'];
        $series->airing_time = $request['airing_time'];
        $series->save();
        return redirect('series');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $menuSerieses = Series::take(5)->get();
        $id = (int)$id;
        if ($id < 1) return view('series.error', compact('menuSerieses'))->with('message', trans("This page does not exists"));
        $series = Series::find($id);
        if (!$series) return view('series.error', compact('menuSerieses'))->with('message', trans("This page does not exists"));

        $follow = new Follow();
        $follow->series_id = $id;
        $follow->user_id = Auth::id();
        $series->is_follow = $follow->isFollow();

        return view('series.show', compact('series', 'menuSerieses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!$this->isAdmin()) return $this->noPerm();
        $id = (int)$id;
        if ($id < 1) return view('series.error')->with('message', trans("This page does not exists"));
        $series = Series::find($id);
        if (!$series) return view('series.error')->with('message', trans("This page does not exists"));

        return view('series.vedit', compact('series'))->with('submiturl', route('series.update',$id));
    }

    /**
     * add user follow
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function follow($id)
    {
        $id = (int)$id;
        if ($id < 1) return trans("This series deleted or not exists");
        $series = Series::find($id);
        if (!$series) return trans("This series deleted or not exists");

        $follow = new Follow();
        $follow->series_id = $id;
        $follow->user_id = Auth::id();
        if (!$follow->isFollow())
            $follow->save();
        $series = Series::find($id);

        return $series->followers->count();
    }

    /**
     * remove user follow
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function unfollow($id)
    {
        $id = (int)$id;
        if ($id < 1) return trans("This series deleted or not exists");
        $series = Series::find($id);
        if (!$series) return trans("This series deleted or not exists");

        Follow::where('series_id', '=', $id)->where('user_id', '=', Auth::id())->delete();;

        $series = Series::find($id);

        return $series->followers->count();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Series $series)
    {
        if (!$this->isAdmin()) die('No Permission');
        request()->validate(Series::$rules);
        $series->title = $request['title'];
        $series->description = $request['description'];
        $series->airing_time = $request['airing_time'];

        $series->update($request->all());

        return redirect()->route('series.index')
            ->with('success', 'series updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$this->isAdmin()) die('No Permission');
        $id = (int)$id;
        if ($id < 1) return redirect()->route('series.error')
            ->with('error', 'This page does not exists');

        $series = Series::find($id);
        if (!$series) return redirect()->route('series.error')
            ->with('error', 'This series deleted or not exists');

        $series->delete();

        return redirect()->route('series.index')
            ->with('success', 'Series deleted successfully');
    }


    /**
     * Display an error message
     *
     * @return \Illuminate\Http\Response
     */
    public function error()
    {
        $menuSerieses = Series::take(5)->get();
        return view('series.error', compact('menuSerieses'))->with('message', '');
    }

}
