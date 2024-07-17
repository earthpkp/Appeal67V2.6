<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\FrontUser;

class DefaultData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $emData = [
            [
                'name'=>'dev',
                'email'=>'dev@tmd.com',
                'password'=>bcrypt('123456'),
                'user_role_id'=>'1'
            
            ],
            
            [
                'name'=>'employee',
                'email'=>'em@tmd.com',
                'password'=>bcrypt('123456'),
                'user_role_id'=>'2'
            
            ],


];

foreach($emData as $key => $val){
    FrontUser::create($val);
}  
    }
}