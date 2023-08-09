<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRecords = [
            [
                'id'=>1,
                'name'=>'Yuriy Novikov',
                'type'=>'superadmin',
                'mobile'=>'0689805417',
                'email'=>'ynovikov14@gmail.com',
                'password'=>'$2y$10$W5trlQGJE6fodJZF6cVjD.U7a70UvvuEE/l9a4HLeZ1mI5MqDw7dq',
                'image'=>'',
                'status'=>1
            ],
            [
                'id'=>2,
                'name'=>'John',
                'type'=>'subadmin',
                'mobile'=>'0111222333',
                'email'=>'john@admin.com',
                'password'=>'$2y$10$W5trlQGJE6fodJZF6cVjD.U7a70UvvuEE/l9a4HLeZ1mI5MqDw7dq',
                'image'=>'',
                'status'=>1
            ],
            [
                'id'=>3,
                'name'=>'Steve',
                'type'=>'subadmin',
                'mobile'=>'0444555666',
                'email'=>'steve@admin.com',
                'password'=>'$2y$10$W5trlQGJE6fodJZF6cVjD.U7a70UvvuEE/l9a4HLeZ1mI5MqDw7dq',
                'image'=>'',
                'status'=>1
            ],
            [
                'id'=>4,
                'name'=>'Amit',
                'type'=>'subadmin',
                'mobile'=>'0666777888',
                'email'=>'amit@admin.com',
                'password'=>'$2y$10$W5trlQGJE6fodJZF6cVjD.U7a70UvvuEE/l9a4HLeZ1mI5MqDw7dq',
                'image'=>'',
                'status'=>1
            ],
        ];

        Admin::insert($adminRecords);
    }
}
