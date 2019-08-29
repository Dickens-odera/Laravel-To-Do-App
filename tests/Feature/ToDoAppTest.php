<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Tasks;
class ToDoAppTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    /** @test */
    public function testToSeeThatOnlyLoggedInUsersCanViewTheTaskLists()
    {
        $response = $this->get('/task');
        $response->assertRedirect('/login');
    }
    /** @test */
    // public function testThataNewTaskCanBeCreated()
    // {
        
    // }
}
