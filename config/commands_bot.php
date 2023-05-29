<?php
use  App\Service\Bot\StartService;
use App\Service\Bot\StudentService;
use App\Service\Bot\TeacherService;

return [
    // Комманды и их методы
    'commands' => [
        '/start' => [
            'class' => StartService::class,
            'method' => 'start'
        ],
        '/auth' => [
            'class' => TeacherService::class,
            'method' => 'auth'
        ]
    ],
    // Кнопки и их методы
    'buttons' => [
        'student' => [
            'class' => StartService::class,
            'method' => 'student'
        ],
        'teacher' => [
            'class' => StartService::class,
            'method' => 'teacher'
        ],
        'stGroups' => [
            'class' => StudentService::class,
            'method' => 'groups'
        ],
        'stDate' => [
            'class' => StudentService::class,
            'method' => 'date'
        ],
        'thDate' => [
            'class' => TeacherService::class,
            'method' => 'date'
        ],
        'thGroup' => [
            'class' => TeacherService::class,
            'method' => 'groups'
        ],
        'selGroup' => [
            'class' => TeacherService::class,
            'method' => 'dates'
        ]
    ]
];
