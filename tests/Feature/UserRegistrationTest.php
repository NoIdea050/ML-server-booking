<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Faker\Factory as Faker;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_register()
    {
        $faker = Faker::create();
    
        $userData = [
            'name' => $faker->name,
            'username' => $faker->unique()->userName,
            'dob' => $faker->date('Y-m-d'),
            'email' => $faker->unique()->safeEmail,
            'password' => 'password123',
        ];
    
        $response = $this->post(route('register'), $userData);
    
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    
        $user = User::where('email', $userData['email'])->first();
        $this->assertNotNull($user);
        $this->assertEquals($userData['name'], $user->name);
        $this->assertEquals($userData['username'], $user->username);
        $this->assertEquals($userData['dob'], $user->dob);
        $this->assertTrue(Hash::check($userData['password'], $user->password));
    }
}
