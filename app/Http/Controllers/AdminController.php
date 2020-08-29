<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function isAdmin() {
        return Auth::id() == 1;
    }

    protected function noPerm() {
        return redirect()->route('home')
                ->with('status', 'Permission Denied');
    }

}
