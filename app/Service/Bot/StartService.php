<?php

namespace App\Service\Bot;

use App\Helpers\Telegram;
use App\Models\Group;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StartService
{
    protected $telegram;
    protected $buttonsService;

    public function __construct()
    {
        $this->telegram = new Telegram(new Http());
        $this->buttonsService = new ButtonsService();
    }

    public function start($data):void
    {
        $userId = (int)$data['message']['from']['id'];

        $buttons = [
            'inline_keyboard' => [
                [
                    [
                        'text' => 'Студент',
                        'callback_data' => json_encode(['key' => 'student', 'type' => 'buttons'])
                    ],
                    [
                        'text' => 'Преподаватель',
                        'callback_data' => json_encode(['key' => 'teacher', 'type' => 'buttons'])
                    ],
                ]
            ]
        ];

        $this->telegram->sendButtons($userId, (string)view('bot.report.start_message'), json_encode($buttons));
    }

    public function student($data):void
    {
        // Мой id телеги 856835272
        $groups = Group::get(['id', 'name'])->toArray();
        $result = [];
        $count = 0;
        $column = [];
        $userId = (int)$data['callback_query']['from']['id'];

        foreach($groups as $key => $group) {
            $column[] = $this->buttonsService->getDateByGroupIdButton('stGroups', $group);

            $count++;

            if((count($groups) - 1) === $key) {
                $result[] = $column;
                break;
            }

            if($count === 2) {
                $result[] = $column;
                $column = [];
                $count = 0;
            }
        }

        $buttons = [
            'inline_keyboard' => $result
        ];

        $this->telegram->sendButtons($userId, (string)view('bot.select_group'), json_encode($buttons));
    }

    public function teacher($data)
    {
        $userId = (int)$data['callback_query']['from']['id'];

        $this->telegram->sendMessage($userId, (string)view('bot.teacher.hello_teacher'));
    }
}
