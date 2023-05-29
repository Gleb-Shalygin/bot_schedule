<?php

namespace App\Service\Bot;

use App\Helpers\Telegram;
use App\Models\TelegramUser;
use App\Models\User;
use App\Service\ScheduleService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TeacherService
{
    protected Telegram $telegram;
    protected ButtonsService $buttonsService;

    public function __construct()
    {
        $this->telegram = new Telegram(new Http());
        $this->buttonsService = new ButtonsService();
    }

    public function auth($data)
    {
        Log::debug('------------------------- наша дата');
        $text = trim($data['message']['text'], '/auth ');
        $userId = (int)$data['message']['from']['id'];
        $dataAuth = explode(', ', $text);

        if(!isset($dataAuth[0]) || !isset($dataAuth[1])) {
            $this->telegram->sendMessage($userId, (string)view('bot.dont_palomka'));
            exit;
        }

        $login = $dataAuth[0];
        $password = $dataAuth[1];

        $user = User::where('email', $login)->get(['id', 'email', 'password', 'name'])->toArray();
        $isTelegramUser = TelegramUser::where('telegram_id', $userId)->get()->toArray();

        switch (true) {
            case isset($isTelegramUser[0]['teacher_id']):
                $buttons = [
                    'inline_keyboard' => $this->buttonsService->getMenuButton()
                ];

                $this->telegram->sendButtons($userId, 'Вы уже авторизованы', $buttons);

                break;
            case !isset($user[0]['email']):
                TelegramUser::where('telegram_id', $userId)->delete();
                $this->telegram->sendMessage($userId, (string)view('bot.teacher.password_notconfirm'));
                break;
            case password_verify($password, $user[0]['password']):
                $telegramUser = TelegramUser::where('teacher_id', $user[0]['id'])->get()->toArray();

                TelegramUser::where([['teacher_id', null], ['telegram_id', $userId]])->delete();

                if(!isset($telegramUser[0]['telegram_id'])) {
                    TelegramUser::insert([
                        'telegram_id' => $userId,
                        'teacher_id' => (int)$user[0]['id']
                    ]);
                }
                Log::debug($telegramUser);

                if(isset($telegramUser[0]['telegram_id']) && $telegramUser[0]['telegram_id'] !== $userId) {
                    $telegramUser = TelegramUser::where('teacher_id', $user[0]['id'])->first();
                    $telegramUser->telegram_id = $userId;
                    $telegramUser->save();
                }

                $buttons = [
                    'inline_keyboard' => $this->buttonsService->getMenuButton()
                ];

                $this->telegram->sendButtons($userId, (string)view('bot.teacher.menu', ['name' => $user[0]['name']]), $buttons);
                break;
            default:
                TelegramUser::where('telegram_id', $userId)->delete();
                $this->telegram->sendMessage($userId, (string)view('bot.teacher.password_notconfirm'));
        }
    }

    public function groups($data)
    {
        $userId = (int)$data['callback_query']['from']['id'];

        $teacher = TelegramUser::where('telegram_id', $userId)->first();

        $user = User::with(['groups'])->find($teacher->teacher_id);

        $groupsButton = [];

        foreach ($user->groups as $group)
            $groupsButton[] = [
                'text' => $group->name,
                'callback_data' => json_encode(['key' => 'selGroup', 'type' => 'buttons', 'idGroup' => $group->id])
            ];

        $buttons = [
            'inline_keyboard' => array_merge([$groupsButton], $this->buttonsService->getMenuButton())
        ];

        $this->telegram->sendButtons($userId, '<b>Выберите группу:</b>', $buttons);
    }

    public function dates($data)
    {
        $userId = (int)$data['callback_query']['from']['id'];
        $data = (array)json_decode($data['callback_query']['data']);

        $buttons = [
            'inline_keyboard' =>
                array_merge($this->buttonsService->getDatesButton('thDate', $data['idGroup']),
                    $this->buttonsService->getMenuButton())
        ];

        $this->telegram->sendButtons($userId, (string)view('bot.select_date'), $buttons);
    }

    public function date($data)
    {
        $userId = (int)$data['callback_query']['from']['id'];
        $data = (array)json_decode($data['callback_query']['data']);

        $schedule = (new ScheduleService())->getDataTable(['date' => $data['date'], 'group' => $data['id']]);

        $buttons = [
            'inline_keyboard' => array_merge([
                $this->buttonsService->getTodayAndTomorrowButton('thDate', $data['id'])
            ], $this->buttonsService->getMenuButton())
        ];

        if($schedule !== [])
            $this->telegram->sendButtons($userId, (string)view('bot.schedule_list', $schedule[0]), json_encode($buttons));

        if($schedule === [])
            $this->telegram->sendButtons($userId, '<b>Данные не загружены!</b>', json_encode($buttons));
    }
}
