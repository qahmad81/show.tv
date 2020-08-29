<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Series;
use App\Episode;
use Storage;
use File;
use Image;
/**
 * Class EpisodeController
 * @package App\Http\Controllers
 */
class EpisodeController extends AdminController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!$this->isAdmin()) return $this->noPerm();
        $episodes = Episode::paginate();
        return view('episodes.index', compact('episodes'))
            ->with('i', (request()->input('page', 1) - 1) * $episodes->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!$this->isAdmin()) return $this->noPerm();
       // die(Storage::disk('episodes')->path(''));
        $serieses = Series::get();
        //if (config('app.vue', true)) 
            return view('episodes/vadd')->with('serieses', $serieses)
                ->with('submiturl', route('episodes.store'));
        //else
        //    return view('episodes/add')->with('serieses', $serieses);
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
        $request->validate(Episode::$rules);

        $episodes = new Episode();
        $episodes->series_id = $request['series_id'];
        $episodes->title = $request['title'];
        $episodes->description = $request['description'];
        $episodes->duration = $request['duration'];
        $episodes->airing_time = $request['airing_time'];
        if ($request['image']){
            $image = $request['image'];
            $ext = $image->getClientOriginalExtension();
            $imgname = time() . '.' . $ext;

            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(250,140);
            $image_resize->save(Storage::disk('episodes')->path('') . $imgname);

            $episodes->image = $imgname;
        }
        if ($request['video']){
            $video = $request['video'];
            $ext = $video->getClientOriginalExtension();
            $videoName = time() . '.' . $ext;

            Storage::disk('episodes')->put($videoName, File::get($video));
            $episodes->video = $videoName;
        }
        $episodes->save();
        return redirect('episodes');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $episode = Episode::find($id);

        $videoAry = explode('.', $episode->video);

        $episode->ext = $videoAry[count($videoAry)-1];
        $menuSerieses = Series::take(5)->get();

        return view('episodes.show', compact('episode', 'menuSerieses'));
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
        $episode = Episode::find($id);
        $serieses = Series::pluck('title', 'id');

        return view('episodes.edit', compact('episode', 'serieses'))
            ->with('submiturl', route('episodes.update', $episode->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Episode $episode)
    {
        if (!$this->isAdmin()) die('No Permission');
        $request->validate(Episode::$rules);


        $episode->series_id = $request['series_id'];
        $episode->title = $request['title'];
        $episode->description = $request['description'];
        $episode->duration = $request['duration'];
        $episode->airing_time = $request['airing_time'];

        if ($request['image']){
            $image = $request['image'];
            $ext = $image->getClientOriginalExtension();
            $imgname = time() . '.' . $ext;

            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(250,140);
            $image_resize->save(Storage::disk('episodes')->path('') . $imgname);

            Storage::disk('episodes')->delete($episode->image);

            $episode->image = $imgname;
        }
        if ($request['video']){
            $video = $request['video'];
            $ext = $video->getClientOriginalExtension();
            $videoName = time() . '.' . $ext;

            Storage::disk('episodes')->put($videoName, File::get($video));
            Storage::disk('episodes')->delete($episode->video);
            $episode->video = $videoName;
        }

        $episode->update();

        return redirect()->route('episodes.index')
            ->with('success', 'Episode Saved successfully.');
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
        $episode = Episode::find($id)->delete();

        return redirect()->route('episodes.index')
            ->with('success', 'Episode deleted successfully');
    }
}
