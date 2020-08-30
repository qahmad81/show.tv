<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * Class Episode
 *
 * @property $id
 * @property $series_id
 * @property $user_id
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Follow extends Model
{
    static $rules = [
            'series_id' => 'required',
            'user_id' => 'required',
    ];

    protected $fillable = ['series_id','user_id'];

    public function episode() {
    	return $this->belongsTo(Episode::class);
    }

    public function user() {
    	return $this->belongsTo(User::class);
    }


    public function isFollow() {
        return $this->where('series_id', '=', $this->series_id)->where('user_id', '=', $this->user_id)->count();
    }

}
