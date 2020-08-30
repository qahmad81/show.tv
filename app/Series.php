<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Series
 *
 * @property $id
 * @property $title
 * @property $description
 * @property $airing_time
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Series extends Model
{
    static $rules = [
        'title' => 'required|max:90|min:3',
        'description' => 'required|max:20240|min:20',
        'airing_time' => 'required|max:50',
    ];
    
    protected $perPage = 5;

    public function episodes() {
    	return $this->hasMany(Episode::class);
    }

    public function followers() {
        return $this->hasMany(Follow::class);
    }

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['title','description','airing_time'];


}
