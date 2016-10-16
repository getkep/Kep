<?php

    require_once 'vendor/autoload.php';

    use Kep\Routing\Route;

    Route::group('v1', function () {
        Route::post('testing', ['uses' => 'MyController@testing']);

        Route::post('gettingstarted', function () {
            // Coding
        });
    });
