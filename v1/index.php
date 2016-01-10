<?php

    require_once '../kep/autoload.php';

    use route\Route;

    Route::group('v1', function () {

        Route::post('testing', ['uses' => 'myController@testing']);

        Route::post('gettingstarted', function () {
            // Coding
        });

    });
