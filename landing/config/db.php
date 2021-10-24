<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=' . getenv('POSTGRES_HOST') . ';port=' . getenv('POSTGRES_PORT') . ';dbname=' . getenv('POSTGRES_DB'),
    'username' => getenv('POSTGRES_USER'),
    'password' => getenv('POSTGRES_PASSWORD'),
    'schemaMap' => [
        'pgsql' => [
            'class' => 'yii\db\pgsql\Schema',
            'defaultSchema' => getenv('POSTGRES_SCHEMA')
        ]
    ],
    'charset' => 'utf8',
    'on afterOpen' => function($event) {
        $event->sender->createCommand('SET search_path TO '. getenv('POSTGRES_SCHEMA'))->execute();
    }
];
