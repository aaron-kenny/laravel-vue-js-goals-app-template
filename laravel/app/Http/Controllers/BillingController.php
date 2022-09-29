<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    /**
     * Return the user's billing information
     *
     * @param  \App\Goal  $goal
     * @return \Illuminate\Http\Response
     */
    public function getBilling()
    {
        // TODO: query builder to get plan info + limited user info
        $userBilling = Goal::where([
                ['user_id', '=', auth()->id()]
            ])
            ->orderBy('order', 'asc')
            ->with('tasks')
            ->get();
        return $userBilling;
    }
}
