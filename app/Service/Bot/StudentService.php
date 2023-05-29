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
    protected $buttonsService;

    public function __construct()
    {
        $this->telegram = new Telegram(new Http());
        $this->buttonsService = new ButtonsService();
    }

    public function groups($data)
    {
        $userId = (int)$data['callback_query']['from']['id'];

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
            $telegramUser->teacher_id = null;
            $telegramUser->save();
        }

        $buttons = [
            'inline_keyboard' => $this->buttonsService->getDatesButton('stDate')
        ];

        $this->telegram->sendButtons($userId, (string)view('bot.select_date'), json_encode($buttons));

    }

    public function date($data)
    {
        $userId = (int)$data['callback_query']['from']['id'];

        if ($this->checkOnTeacher($userId))
            exit;

        $data = (array)json_decode($data['callback_query']['data']);

        $telegramUser = TelegramUser::where('telegram_id', $userId)->get(['group_id']);

        $schedule = (new ScheduleService())->getDataTable(['date' => $data['date'], 'group' => $telegramUser[0]['group_id']]);

        $buttons = [
            'inline_keyboard' => [
                $this->buttonsService->getTodayAndTomorrowButton('stDate'),
                [
                    $this->buttonsService->getDateByGroupIdButton('stGroups', ['name' => 'Даты (текущая и след. неделя)', 'id' => $telegramUser[0]['group_id']])
                ]
            ]
        ];

        if($schedule !== [])
            $this->telegram->sendButtons($userId, (string)view('bot.schedule_list', $schedule[0]), json_encode($buttons));

        if($schedule === [])
            $this->telegram->sendButtons($userId, '<b>Данные не загружены!</b>', json_encode($buttons));
    }

    private function checkOnTeacher($userId): bool
    {
        $telegramUser = TelegramUser::where('telegram_id', $userId)->get()->toArray();

        if(isset($telegramUser[0]['teacher_id']))
            $this->telegram->sendMessage($userId, (string)view('bot.dont_palomka'));

        return isset($telegramUser[0]['teacher_id']);
    }
}
