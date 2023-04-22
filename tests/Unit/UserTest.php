<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use App\Models\User;
use Database\Seeders\UsersTableSeeder;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }
    public function test_login_form()
    {
        $response = $this -> get('/login') ;

        $response -> assertStatus (200) ;
    }

    public function test_duplicate_user()
    {
        $user1 = User::make([
            'name' => 'John Doe',
            'email' => 'johndoe@gmail.com'
        ]);

        $user2 = User::make([
            'name' => 'Rania Rex',
            'email' => 'raniarex@gmail.com'
        ]);

        $this->assertTrue($user1->name != $user2->name);
    }

    public function test_delete_user()
    {
        $user = User::factory()->count(1)->make();
  
        $user = User::first();
    
        if($user) {
            $user->delete();
        }
    
        $this->assertTrue(true);
    }



}
