<?php
use  App\Service\Bot\StartService;
use App\Service\Bot\StudentService;

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
        ],
        'stGroups' => [
            'class' => StudentService::class,
            'method' => 'groups'
        ],
        'stDate' => [
            'class' => StudentService::class,
            'method' => 'date'
        ]
    ]
];
