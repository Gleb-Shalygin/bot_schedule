<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\ScheduleService;

class ScheduleController extends Controller
{
    protected $scheduleService;
    public function __construct()
    {
        $this->scheduleService = new ScheduleService();
    }

    public function index()
    {
        return view('schedule.schedule');
    }

    public function getDataTable()
    {
        return $this->scheduleService->getDataTable();
    }
}
