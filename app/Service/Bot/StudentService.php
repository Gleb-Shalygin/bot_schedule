<?php

namespace App\Service\Bot;

use App\Helpers\Telegram;
use App\Models\TelegramUser;
use App\Service\ScheduleService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StudentService
{
    protected $telegram;

    public function __construct()
    {
        $this->telegram = new Telegram(new Http());
    }

    public function groups($data)
    {
        $userId = (int)$data['callback_query']['from']['id'];
        $date = strtotime('monday this week');
        $result = [];
        $count = 0;
        $column = [];

        $data = (array)json_decode($data['callback_query']['data']);

        $telegramUser = TelegramUser::where('telegram_id', $userId)->get()->toArray();

        if(!isset($telegramUser[0]['telegram_id']))
            $telegramUser = TelegramUser::insert([
                'telegram_id' => $userId,
                'group_id' => $data['id']
            ])->get()->toArray();

        if($telegramUser[0]['group_id'] !== (int)$data['id']) {
            $telegramUser = TelegramUser::where('telegram_id', $userId)->first();
            $telegramUser->group_id = (int)$data['id'];
            $telegramUser->save();
        }

        for ($i = 0;$i < 14;$i++) {
            $column[] = [
                'text' => date("Y-m-d", $date),
                'callback_data' => json_encode(['key' => 'stDate', 'type' => 'buttons', 'date' => date("Y-m-d", $date)])
            ];
            $count++;
            $date = strtotime('+1 day', $date);

            if($i === 13) {
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

        $this->telegram->sendButtons($userId, (string)view('bot.select_date'), json_encode($buttons));

    }

    public function date($data)
    {
        $userId = (int)$data['callback_query']['from']['id'];
        $data = (array)json_decode($data['callback_query']['data']);

        $telegramUser = TelegramUser::where('telegram_id', $userId)->get(['group_id']);

        $schedule = (new ScheduleService())->getDataTable(['date' => $data['date'], 'group' => $telegramUser[0]['group_id']]);

        $buttons = [
            'inline_keyboard' => [
                [
                    [
                        'text' => 'Сегодня',
                        'callback_data' => '1'
                    ],
                    [
                        'text' => 'Завтра',
                        'callback_data' => '2'
                    ]
                ]
            ]
        ];

        $http = $this->telegram->sendButtons($userId, (string)view('bot.schedule_list', $schedule[0]), json_encode($buttons));

        Log::debug($http);
    }
}
