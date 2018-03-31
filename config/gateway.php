<?php

return [
    'scopes' => [
        'read' => 'Read',
        'write' => 'Write',
        'posts' => 'Posts'
    ],
    'services' => [
        'jsonplaceholder' => \App\Http\Services\JsonPlaceholder::class
    ],
    'aggregations' => [
        'jsonplaceholder' => \App\Http\Aggregations\JsonPlaceholder::class
    ]
];
