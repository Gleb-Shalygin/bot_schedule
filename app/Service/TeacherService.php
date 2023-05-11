<?php

namespace App\Service;

use App\Models\Group;
use App\Models\TeacherGroup;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeacherService
{
    public function getDataTable()
    {
        return User::with('groups')->get(['id', 'name']);
    }

    public function create($modal)
    {
        $groups = $modal['groups'];

        unset($modal['groups']);

        DB::transaction(function() use ($modal, $groups){
            $user = User::create([
                'name' => $modal['name'],
                'email' => $modal['email'],
                'password' => Hash::make($modal['password'])
            ]);

            foreach($groups as $groupItem) {
                $group = Group::where('name', $groupItem['name'])->get();

                if(isset($group[0])) {
                    TeacherGroup::create([
                        'id_group' => $group->id,
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
