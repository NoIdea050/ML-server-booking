<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'role_id' => '2',
            'employee_id' => '0',
            'name' => 'Admin',
            'email' => 'admin@mlbooking.com',
            'password' => bcrypt('Admin100'),
            'status' => '2',
        ]);

        DB::table('users')->insert([
            'role_id' => '5',
            'employee_id' => '0',
            'name' => 'User',
            'username' => 'user01',
            'email' => 'user@mlbooking.com',
            'password' => bcrypt('user0001'),
            'status' => '1',
        ]);

        DB::table('credits')->insert([
            'user_id' => 1,
            'total_credit_gain' => 100,
            'total_credit_left' => 100,
            'last_credit_added' => 100,
            'last_credit_added_date' => date('Y-m-d')
        ]);

        DB::table('settings')->insert([
            'project_name' => 'ML Server Booking System',
            'address' => 'UK',
            'phone' => '07XXXXXXXXX',
            'email' => 'mlbooking.system@gmail.com',
            'monthly_credit' => 100,
            'cpu_cost_per_hour' => 1,
            'gpu_cost_per_hour' => 1.5
        ]);
    }
}
