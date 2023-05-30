<?php

namespace App\Service\Bot;

class ButtonsService
{
    public function getTodayAndTomorrowButton($prop, $idGroup = 0): array
    {
        $dateToday = date("Y-m-d", strtotime("now"));
        $dateTomorrow = date("Y-m-d", strtotime("+1 day"));

        return [
            [
                'text' => 'Сегодня',
                'callback_data' => json_encode(['key' => $prop, 'type' => 'buttons', 'date' => $dateToday, 'id' => $idGroup])
            ],
            [
                'text' => 'Завтра',
                'callback_data' => json_encode(['key' => $prop, 'type' => 'buttons', 'date' => $dateTomorrow, 'id' => $idGroup])
            ]
        ];
    }

    public function getDatesButton($prop, $idGroup = 0): array
    {
        $date = strtotime('monday this week');
        $buttons = [];
        $count = 0;
        $column = [];

        for ($i = 0; $i < 14; $i++) {
            $column[] = [
                'text' => date("Y-m-d", $date),
                'callback_data' => json_encode(['key' => $prop,
                    'type' => 'buttons',
                    'date' => date("Y-m-d", $date),
                    'id'=> $idGroup])
            ];
            $count++;
            $date = strtotime('+1 day', $date);

            if($i === 13) {
                $buttons[] = $column;
                break;
            }

            if($count === 2) {
                $buttons[] = $column;
                $column = [];
                $count = 0;
            }
        }

        return $buttons;
    }

    public function getDateByGroupIdButton($prop, $group): array
    {
        return [
            'text' => $group['name'],
            'callback_data' => json_encode(['key' => $prop, 'type' => 'buttons', 'id' => $group['id']])
        ];
    }

    public function getMenuButton()
    {
        $dateToday = date("Y-m-d", strtotime("now"));

        return [
            [
                [
                    'text' => 'Ваша группа',
                    'callback_data' => json_encode(['key' => 'thGroup', 'type' => 'buttons'])
                ]
            ],
            [
                [
                    'text' => 'Ваше расписание',
                    'callback_data' => json_encode(['key' => 'schedule', 'type' => 'buttons', 'date' => $dateToday])
                ]
            ],
            [
                [
                    'text' => 'Закрепить объявление',
                    'callback_data' => json_encode(['key' => 'news', 'type' => 'buttons'])
                ]
            ]
        ];
    }

}
