<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddTeacherRequest;
use App\Service\TeacherService;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    protected $teacherService;


    public function __construct(TeacherService $teacherService)
    {
        $this->teacherService = $teacherService;
    }

    public function index()
    {
        return view('teachers.teachers');
    }

    public function getDataTable(Request $request): \Illuminate\Database\Eloquent\Collection|array
    {
//        dd($request);
        return $this->teacherService->getDataTable($request->input('filter'));
    }

    public function getTeacher($id)
    {

        return $this->teacherService->getTeacherById($id);
    }

    public function create(AddTeacherRequest $request): array
    {
        return $this->teacherService->create($request);
    }

    public function delete(Request $request): array
    {
        return $this->teacherService->deleteUser($request->input('id'));
    }

    public function edit(Request $request)
    {
        return $this->teacherService->editTeacher($request);
    }
}
