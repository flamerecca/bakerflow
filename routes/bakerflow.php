<?php
Route::group(['as' => 'bakerflow.'], function () {
    $namespacePrefix = '\\Flamerecca\\Bakerflow\\Http\\Controllers\\';

    Route::get('/index', $namespacePrefix . 'BakerflowController@index');
});