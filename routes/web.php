<?php

use Illuminate\Support\Facades\Route;

Route::get('array', function () {
    return json_encode(
        [
            'array-1' => [
                'id' => 1
            ],
            'array-2' => [
                'id' => 2
            ]
        ]
    );
});

Route::get('array/{arrayId}', function (int $arrayId) {
    return json_encode(
        [
            'array' => [
                'id' => $arrayId
            ]
        ]
    );
});