<?php

return [
    '' => [
        'controller' =>  'main',
        'action' => 'index',
    ],
    'login' => [
        'controller' =>  'main',
        'action' => 'login',
    ],
    'add' => [
        'controller' =>  'main',
        'action' => 'addTask',
    ],
    'edit/{id:\d+}' => [
        'controller' =>  'main',
        'action' => 'editTask',
    ],
    'taskMarkedReady' => [
        'controller' =>  'main',
        'action' => 'TaskMarkedReady',
    ],
    'logout' => [
        'controller' =>  'main',
        'action' => 'logout',
    ]
];
