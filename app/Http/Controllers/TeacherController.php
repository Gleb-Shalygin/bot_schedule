<?php

namespace App\Http\Controllers;

use App\Service\TeacherService;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    protected $teacherService;


    public function __construct(TeacherService $teacherService)
    {
        $this->teacherService = $teacherService;
    }

    public function index() {
        return view('teachers.teachers');
    }

    public function getDataTable()
    {
        return $this->teacherService->getDataTable();
    }

    public function create(Request $request)
    {
        return $this->teacherService->create($request);
    }
}
