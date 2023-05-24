<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\ScheduleService;
use Illuminate\Http\Request;

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

    public function getDataTable(Request $request): array
    {
        return $this->scheduleService->getDataTable($request->input());
    }

    /**
     * @throws \Exception
     */
    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->scheduleService->create($request->input()));
    }

    public function edit(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->scheduleService->edit($request->input()));
    }
}
