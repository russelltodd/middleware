<?php

/*
 * Routes for the Chms methods
 */

$app->group([
    'prefix' => 'chms',
    'namespace' => 'App\Http\Controllers\Chms'],
    function($app) {

        $app->get('person/{id}', ['as' => 'person.get', 'uses' => 'People@getPerson']);
});