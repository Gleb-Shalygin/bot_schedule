<?php

namespace App\Service;

use App\Models\Group;
use App\Models\TeacherGroup;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeacherService
{
    public function getDataTable($filter)
    {
        return User::with('groups')
            ->where('name', 'LIKE', '%'.$filter.'%')
            ->get(['id', 'name']);
    }

    public function create($modal)
    {
        $groups = $modal['groups'];

        unset($modal['groups']);

        DB::transaction(function() use ($modal, $groups){
            try {
                $user = User::create([
                    'name' => $modal['name'],
                    'email' => $modal['email'],
                    'password' => Hash::make($modal['password'])
                ]);
            }catch (\Exception $e) {
                throw new \Exception('Пользователь уже существует');
            }

            foreach($groups as $groupItem) {
                $group = Group::where('name', $groupItem['name'])->get();

                if(isset($group[0])) {
                    TeacherGroup::create([
                        'id_group' => $group[0]->id,
                        'id_teacher' => $user->id
                    ]);

                    continue;
                }

                $group = Group::create([
                    'name' => $groupItem['name']
                ]);

                TeacherGroup::create([
                    'id_group' => $group->id,
                    'id_teacher' => $user->id
                ]);
            }
        });

        return ['status' => 201];
    }

    public function getTeacherById($id): array
    {
        $user = User::with(['groups'])->where('id', $id)->get()->toArray();
        $groups = [];

        foreach ($user[0]['groups'] as $group)
            $groups[] = ['name' => $group['name']];

        return [
            'id' => $user[0]['id'],
            'name' => $user[0]['name'],
            'email' => $user[0]['email'],
            'groups' => $groups
        ];
    }

    public function deleteUser($id): array
    {
        DB::transaction(function () use ($id) {

            User::where('id', $id)->delete();

            TeacherGroup::where('id_teacher', $id)->delete();
        });

        return ['status' => 203];
    }

    public function editTeacher($data)
    {
        $groups = $data['groups'];

        unset($data['groups']);

        DB::transaction(function() use ($data, $groups){
            TeacherGroup::where('id_teacher', $data['id'])->delete();

            $user = User::find($data['id']);

            $user->name = $data['name'];
            $user->email = $data['email'];

            if(isset($data['password']))
                $user->password = $data['password'];

            $user->save();

            foreach ($groups as $groupItem) {
                $group = Group::where('name', $groupItem['name'])->get();

                if(isset($group[0])) {
                    TeacherGroup::create([
                        'id_group' => $group[0]->id,
                        'id_teacher' => $user->id
                    ]);

                    continue;
                }

                $group = Group::create([
                    'name' => $groupItem['name']
                ]);

                TeacherGroup::create([
                    'id_group' => $group->id,
                    'id_teacher' => $user->id
                ]);
            }
        });

        return ['status' => 201];
    }
}
