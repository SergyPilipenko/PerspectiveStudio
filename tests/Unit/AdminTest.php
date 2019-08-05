<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function unauthentificated_user_can_not_see_admin_dashboard()
    {


        $this->withExceptionHandling();
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('admin.login'));

    }
    
    /** @test */
    
    function admin_can_see_dashboard()
    
    {

        $this->adminSignIn();

        $this->get(route('admin.import.create'))
            ->assertStatus(200);
        
    }
}
