<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Admin extends Middleware
{
    public function __construct()
    {
        //$user = Auth::user();
        //print_r($user);
        die('dd');
    }
}
