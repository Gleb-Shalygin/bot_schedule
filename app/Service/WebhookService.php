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
        if (isset($data['message']['entities'][0]['type']) && (string)$data['message']['entities'][0]['type'] === 'bot_command') {
//            Log::debug('Здесь?');
            return $this->servicesForCommands($data);
        }

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
        $text = $data['message']['text'];

        // ^\/[a-z]+$ - регулярка на команду
        preg_match('/^\/[a-z]+/', $text, $key, PREG_OFFSET_CAPTURE);

        $class = (string)$this->commands['commands'][$key[0][0]]['class'];
        $method = (string)$this->commands['commands'][$key[0][0]]['method'];

        (new $class())->$method($data);

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
