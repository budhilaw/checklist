<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['middleware' => 'basicAuth'], function () use ($router) {

    /*
    |--------------------------------------------------------------------------
    | Checklists
    |--------------------------------------------------------------------------
    */

    // Get list of checklists.
    $router->get('checklists/', 'ChecklistController@getAll');

    // This creates a Checklist object.
    $router->post('checklists/', 'ChecklistController@create');

    // Get checklist by given checklistId.
    $router->get('checklists/{id}', 'ChecklistController@show');

    // Update checklist by given checklistId
    $router->patch('checklists/{id}', 'ChecklistController@edit');

    // Delete checklist by given checklistId
    $router->delete('checklists/{id}', 'ChecklistController@delete');

    /*
    |--------------------------------------------------------------------------
    | Items
    |--------------------------------------------------------------------------
    */

    // Complete item(s)
    $router->post('checklists/complete', 'ItemController@complete');

    // Incomplete item(s)
    $router->post('checklists/incomplete', 'ItemController@incomplete');

    // Get all items by given {checklistId}
    $router->get('checklists/{checklistid}/items', 'ItemController@getByChecklist');

    // Create item by given checklistId
    $router->post('checklists/{checklistid}/items', 'ItemController@create');

    // Get checklist item by given {checklistId} and {itemId}
    $router->get('checklists/{checklistid}/items/{itemid}', 'ItemController@getByItemId');

    // Edit Checklist Item on given {checklistId} and {itemId}
    $router->patch('checklists/{checklistid}/items/{itemid}', 'ItemController@editByItemId');

    // Delete checklist item by given {checklistId} and {itemId}
    $router->delete('checklists/{checklistid}/items/{itemid}', 'ItemController@deleteByItemId');
});

// $app->group(['middleware' => 'auth'], function () use ($app) {
//     $app->get('/', function ()    {
//         // Uses Auth Middleware
//     });

//     $app->get('user/profile', function () {
//         // Uses Auth Middleware
//     });
// });
