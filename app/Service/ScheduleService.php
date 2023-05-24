<?php

namespace App\Service;

use App\Models\Schedule;

class ScheduleService
{
    public function getDataTable($params): array
    {
        $querySchedule = $this->getQueryResultForDataTable($params);

        return $this->buildForDataTableResultSchedule($querySchedule);
    }

    private function getQueryResultForDataTable($params = [])
    {
        return Schedule::select('schedule.id as id', 'id_group', 'id_call', 'schedule.office as office', 'schedule.pair as pair',
            'calls.week_day as week_day', 'id_couples', 'couples.name as predmet', 'id_user', 'users.name as teacher_name',
            'groups.name as group_name')
            ->selectRaw('DATE_FORMAT(date, "%Y-%m-%d") as date')
            ->leftJoin('calls', 'schedule.id_call', 'calls.id')
            ->leftJoin('groups', 'schedule.id_group', 'groups.id')
            ->leftJoin('couples', 'schedule.id_couples', 'couples.id')
            ->leftJoin('users', 'schedule.id_user', 'users.id')
            ->when((isset($params['date']) && isset($params['group'])),
                fn($query) => $query->whereBetween('schedule.date', [$params['date'].' 00:00:00', $params['date'].' 23:59:59'])
                    ->where('schedule.id_group', $params['group']))
            ->get();
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
                    'id' => $schedule['id'],
                    'pair' => $schedule['pair'],
                    'id_couples' => $schedule['id_couples'],
                    'predmet' => $schedule['predmet'],
                    'id_user' => $schedule['id_user'],
                    'teacher_name' => $schedule['teacher_name'],
                    'office' => $schedule['office'],
                ];

                continue;
            }

            $result[] = [
                'id' => $schedule['id'],
                'date' => $schedule['date'],
                'id_group' => $schedule['id_group'],
                'id_call' => $schedule['id_call'],
                'group_name' => $schedule['group_name'],
                'week_day' => $schedule['week_day'],
                'pairs' => [
                    [
                        'id' => $schedule['id'],
                        'pair' => $schedule['pair'],
                        'id_couples' => $schedule['id_couples'],
                        'predmet' => $schedule['predmet'],
                        'id_user' => $schedule['id_user'],
                        'teacher_name' => $schedule['teacher_name'],
                        'office' => $schedule['office'],

                    ]
                ]
            ];
        }

        return $result;
    }

    /**
     * @throws \Exception
     */
    public function create($params): array
    {
        try {
            Schedule::insert($params);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return ['status' => 201];
    }

    /**
     * @throws \Exception
     */
    public function edit($params)
    {
        try {
            $schedule = Schedule::upsert($params, ['id'], ['id_couples', 'id_user', 'office', 'pair']);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return ['status' => 203];
    }
}
