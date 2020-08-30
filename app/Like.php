<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * Class Episode
 *
 * @property $id
 * @property $episode_id
 * @property $user_id
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Like extends Model
{
    static $rules = [
            'episode_id' => 'required',
            'user_id' => 'required',
    ];
    protected $fillable = ['episode_id','user_id'];

    public function episodes() {
    	return $this->belongsTo(Episode::class);
    }

    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function isLike() {
        return $this->where('episode_id', '=', $this->episode_id)->where('user_id', '=', $this->user_id)->count();
    }

}
