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

//        $serieses = Series::get();
//        return view('series/home')->with('serieses', $serieses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!$this->isAdmin()) return $this->noPerm();
        //if (config('app.vue', false)) 
            return view('series/vadd')->with('submiturl', route('series.store')); 
        //else
        //    return view('series/add');
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
        $series = Series::find($id);
        $menuSerieses = Series::take(5)->get();

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
        $series = Series::find($id);

        return view('series.edit', compact('series'));
    }

    /**
     * add user follow
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function follow($id)
    {
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

        $series->update($request->all());

        return redirect()->route('series.index')
            ->with('success', 'Episode updated successfully');
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
        $series = Series::find($id)->delete();

        return redirect()->route('series.index')
            ->with('success', 'Series deleted successfully');
    }
}
