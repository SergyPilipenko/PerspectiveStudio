<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


//    /** @test */
//    public function user_can_not_login_as_admin()
//    {
//
//        $this->signIn();
//
//        $this->get(route('admin.index'))
//            ->assertStatus(301);
//
//    }
}
