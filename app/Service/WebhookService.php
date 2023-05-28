<?php

namespace App\Service;

use Illuminate\Support\Facades\Log;

class WebhookService
{
    protected $commands;

    public function __construct()
    {
        $this->commands = config('commands_bot');
    }

    public function index($data)
    {
//        Log::debug($data);
        if (isset($data['message']['entities'][0]['type']) && (string)$data['message']['entities'][0]['type'] === 'bot_command')
            return $this->servicesForCommands($data);

        if (isset($data['callback_query']['data']))
            return $this->servicesForButtons($data);

        return response()->json(true, 201);
    }

    /**
     * Сервисы для комманд
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    private function servicesForCommands($data): \Illuminate\Http\JsonResponse
    {
        $key = $data['message']['text'];

        $class = (string)$this->commands['commands'][$key]['class'];
        $method = (string)$this->commands['commands'][$key]['method'];

        $userId = (int)$data['message']['from']['id'];

        (new $class())->$method($userId);

        return response()->json(true, 201);
    }

    private function servicesForButtons($data)
    {
        $queryArray = (array)json_decode($data['callback_query']['data']);

        $type = (string)$queryArray['type'];
        $key = (string)$queryArray['key'];

        $class = $this->commands[$type][$key]['class'];
        $method = $this->commands[$type][$key]['method'];

        (new $class())->$method($data);

        return response()->json(true, 201);
    }
}
