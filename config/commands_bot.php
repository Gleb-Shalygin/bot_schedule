<?php
use  App\Service\Bot\StartService;

return [
    // Комманды и их методы
    'commands' => [
        '/start' => [
            'class' => StartService::class,
            'method' => 'start'
        ]
    ],
    // Кнопки и их методы
    'buttons' => [
        'student' => [
            'class' => StartService::class,
            'method' => 'student'
        ]
    ]
];
