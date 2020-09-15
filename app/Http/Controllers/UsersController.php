<?php

namespace App\Http\Controllers;
use Illuminate\Pagination\Paginator;
use App\User;

class UsersController extends AdminController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!$this->isAdmin()) return $this->noPerm();
        Paginator::useBootstrap();
        $users = User::where('id', '!=',1)->paginate();
        return view('users', compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * $users->perPage());
    }
}
