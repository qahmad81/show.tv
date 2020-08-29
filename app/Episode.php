<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Episode
 *
 * @property $id
 * @property $series_id
 * @property $title
 * @property $description
 * @property $duration
 * @property $airing_time
 * @property $image
 * @property $video
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Episode extends Model
{
    
    static $rules = [
            'title' => 'required|max:90|min:3',
            'series_id' => 'required',
            'description' => 'required|max:20240|min:20',
            'duration' => 'required|integer|max:300',
            'airing_time' => 'required|max:50',
            'image' => 'file|mimes:jpeg,png,gif|max:2024',
            'video' => 'file|mimes:flv,mp4,m3u8,ts,3gp,mov,avi,wmv|max:20000',
    ];

    protected $perPage = 5;

    public function series() {
    	return $this->belongsTo(Series::class);
    }


    public function getrand() {
         return $this->select('episodes.*')->orderBy($this->raw('RAND()'))
        ->take(5)->get();
    }
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['series_id','title','description','duration','airing_time','image','video'];


}
