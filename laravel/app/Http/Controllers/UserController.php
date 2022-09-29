<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Return the user information
     *
     * @param  \App\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function getUser()
    {
        // $user = Goal::where([
        //         ['user_id', '=', auth()->id()]
        //     ])
        //     ->orderBy('order', 'asc')
        //     ->with('tasks')
        //     ->get();
        return Auth::user();
    }
}
