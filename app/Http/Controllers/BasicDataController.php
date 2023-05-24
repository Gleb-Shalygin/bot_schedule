<?php

namespace App\Http\Controllers;

use App\Models\Call;
use App\Models\Couple;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class BasicDataController extends Controller
{
    public function getBasicData(): array
    {
        return [
            'calls' => Call::all(),
            'couples' => Couple::get(['id', 'name']),
            'groups' => Group::all(),
            'teachers' => User::get(['id', 'name'])
        ];
    }
}
