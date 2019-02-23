<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ItemTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testComplete()
    {
        // Disable middleware basic auth
        $this->app->instance('middleware.disable', true);

        $parameters = [
            'item_id' => '1'
        ];

        $this->post('checklists/complete', $parameters, []);
        $this->assertResponseStatus(200);
        $this->seeStatusCode(200);
        $this->seeJson(
            ['status' => 'The item is completed!']
        );
    }

    public function testIncomplete()
    {
        // Disable middleware basic auth
        $this->app->instance('middleware.disable', true);

        $parameters = [
            'item_id' => '1'
        ];

        $this->post('checklists/incomplete', $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJson(
            ['status' => 'The item is incompleted!']
        );
    }

    public function testgetByChecklist()
    {
        // Disable middleware basic auth
        $this->app->instance('middleware.disable', true);

        $this->get('checklists/1/items', [], []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
                'data' => [
                    '*' => [
                        'type',
                        'id',
                        'attributes',
                        'items'
                    ]
                ]
            ]
        );
    }

    public function testCreate()
    {
        // Disable middleware basic auth
        $this->app->instance('middleware.disable', true);

        $parameters = [
            'description' => 'lorem ipsum'
        ];

        $this->post('checklists/1/items', $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJson(
            ['status' => 'The item data successfuly added!']
        );
    }

    public function testgetByItemId()
    {
        // Disable middleware basic auth
        $this->app->instance('middleware.disable', true);

        $this->get('checklists/1/items/3', [], []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
                'data' => [
                    '*' => [
                        'type',
                        'id',
                        'attributes',
                        'items' => [
                            '*' => [
                                'id',
                                'checklist_id'
                            ]
                        ]
                    ]
                ]
            ]
        );
    }

    public function testeditByItemId()
    {
        // Disable middleware basic auth
        $this->app->instance('middleware.disable', true);

        $this->patch('checklists/1/items/3', [], []);
        $this->seeStatusCode(200);
        $this->seeJson(
            ['status' => 'The item data from checklist successfuly edited!']
        );
    }

    public function testdeleteByItemId()
    {
        // Disable middleware basic auth
        $this->app->instance('middleware.disable', true);

        $this->delete('checklists/1/items/3', [], []);
        $this->seeStatusCode(200);
        $this->seeJson(
            ['status' => 'The item from checklist data successfuly deleted!']
        );
    }
}
