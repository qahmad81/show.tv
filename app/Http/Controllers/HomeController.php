<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
    	$fruits = array('mango', 'orange', 'apple');
    	return view('welcome', ['fruits' => $fruits]);
    }
}
