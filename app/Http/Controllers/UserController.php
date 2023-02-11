<?php

namespace App\Http\Controllers;

use \Illuminate\Contracts\View\Factory;
use \Illuminate\Contracts\View\View;
use \Illuminate\Contracts\Foundation\Application;

class UserController extends Controller
{
    public function register(): Factory|View|Application
    {
        return view('user.register');
    }
}
