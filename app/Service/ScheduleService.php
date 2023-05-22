<?php

namespace App\Service;

use App\Models\Schedule;

class ScheduleService
{
    public function getDataTable()
    {
        $resultSchedule = [];
        $querySchedule = Schedule::select('schedule.id as id', 'schedule.office as office', 'schedule.pair as pair',
            'calls.week_day as week_day', 'couples.name as predmet', 'users.name as teacher_name',
            'groups.name as group_name')
            ->selectRaw('DATE_FORMAT(date, "%Y-%m-%d") as date')
            ->leftJoin('calls', 'schedule.id_call', 'calls.id')
            ->leftJoin('groups', 'schedule.id_group', 'groups.id')
            ->leftJoin('couples', 'schedule.id_couples', 'couples.id')
            ->leftJoin('users', 'schedule.id_user', 'users.id')
            ->get();

        return $this->buildForDataTableResultSchedule($querySchedule);
    }

    private function buildForDataTableResultSchedule($querySchedule)
    {
        $result = [];

        foreach($querySchedule as $schedule) {
            if(in_array($schedule['date'], array_column($result, 'date')) &&
                in_array($schedule['group_name'], array_column($result, 'group_name'))) {
//                $currentKey = array_filter($result, function($item) use ($schedule) {
//                    dd($item);
//                    return ($item['date'] === $schedule['date'] && $item['group_name'] === $schedule['group_name']);
//                });
                $currentKey = null;

                foreach($result as $key => $item) {
                    if($item['date'] === $schedule['date'] && $item['group_name'] === $schedule['group_name'])
                        $currentKey = $key;
                }

                $result[$currentKey]['pairs'][] = [
                    'pair' => $schedule['pair'],
                    'predmet' => $schedule['predmet'],
                    'teacher_name' => $schedule['teacher_name'],
                    'office' => $schedule['office']
                ];

                continue;
            }

            $result[] = [
                'id' => $schedule['id'],
                'date' => $schedule['date'],
                'group_name' => $schedule['group_name'],
                'week_day' => $schedule['week_day'],
                'pairs' => [
                    [
                        'pair' => $schedule['pair'],
                        'predmet' => $schedule['predmet'],
                        'teacher_name' => $schedule['teacher_name'],
                        'office' => $schedule['office']
                    ]
                ]
            ];
        }

        return $result;
    }
}
