<?php

namespace App\Service\Bot;

use App\Helpers\Telegram;
use App\Models\Group;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StartService
{
    protected $telegram;

    public function __construct()
    {
        $this->telegram = new Telegram(new Http());
    }

    public function start($userId):void
    {
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

    public function student($userId):void
    {
        // 856835272
        $groups = Group::get(['id', 'name'])->toArray();
        $result = [];

        foreach($groups as $group)
            $result[][] = [
                'text' => $group['name'],
                'callback_data' => json_encode(['key' => 'selectGroups', 'type' => 'buttons', 'id' => $group['id']])
            ];

        list($right, $left) = array_chunk($result, ceil(count($result)/2));

        $buttons = [
            'inline_keyboard' => $result
        ];

        $http = $this->telegram->sendButtons($userId, (string)view('bot.select_group'), json_encode($buttons));

        Log::debug($http);
    }
}
