<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Series;
use App\Episode;
use App\Like;
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
        $serieses = Series::get();
        return view('episodes/vadd')->with('serieses', $serieses)
            ->with('submiturl', route('episodes.store'));
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
        $menuSerieses = Series::take(5)->get();
        $id = (int)$id;
        if ($id < 1) return view('episodes.error', compact('menuSerieses'))->with('message', trans("This page does not exists"));
        $episode = Episode::find($id);
        if (!$episode) return view('episodes.error', compact('menuSerieses'))->with('message', trans("This page does not exists"));

        $videoAry = explode('.', $episode->video);

        $episode->ext = $videoAry[count($videoAry)-1];

        $like = new Like();
        $like->episode_id = $id;
        $like->user_id = Auth::id();
        $episode->is_like = $like->isLike();

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
        $id = (int)$id;
        if ($id < 1) return view('episodes.error')->with('message', trans("This page does not exists"));
        $episode = Episode::find($id);
        if (!$episode) return view('episodes.error')->with('message', trans("This page does not exists"));
        
        $episode->img = Storage::disk('episodes')->url($episode->image);
        $episode->vid = Storage::disk('episodes')->url($episode->video);
        //$serieses = Series::pluck('title', 'id');
        $serieses = Series::get();       

        return view('episodes.vedit', compact('episode', 'serieses'))
            ->with('submiturl', route('episodes.update', $episode->id));
    }


    /**
     * add user like
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function like($id)
    {
        $id = (int)$id;
        if ($id < 1) return trans("This episode deleted or not exists");
        $episode = Episode::find($id);
        if (!$episode) return trans("This episode deleted or not exists");

        $like = new Like();
        $like->episode_id = $id;
        $like->user_id = Auth::id();
        if (!$like->isLike())
            $like->save();
        $episode = Episode::find($id);

        return $episode->likes->count();
    }

    /**
     * remove user dislike
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function dislike($id)
    {
        $id = (int)$id;
        if ($id < 1) return trans("This episode deleted or not exists");
        $episode = Episode::find($id);
        if (!$episode) return trans("This episode deleted or not exists");

        Like::where('episode_id', '=', $id)->where('user_id', '=', Auth::id())->delete();;

        $episode = Episode::find($id);

        return $episode->likes->count();
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
        $id = (int)$id;
        if ($id < 1) return redirect()->route('episodes.error')
            ->with('error', 'This page does not exists');

        $episode = Episode::find($id);
        if (!$episode) return redirect()->route('episodes.error')
            ->with('error', 'This episode deleted or not exists');

        Storage::disk('episodes')->delete($episode->image);
        Storage::disk('episodes')->delete($episode->video);

        $episode->delete();

        return redirect()->route('episodes.index')
            ->with('success', 'Episode deleted successfully');
    }

    /**
     * Display an error message
     *
     * @return \Illuminate\Http\Response
     */
    public function error()
    {
        $menuSerieses = Series::take(5)->get();
        return view('episodes.error', compact('menuSerieses'))->with('message', '');
    }

}
