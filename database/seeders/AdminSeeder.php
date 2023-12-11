<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item = [
           
    'R_id'=>1,
    'name'=>'feras',
    'email'=>'feras@gmail.com',
    'password'=>bcrypt('feras1234')

        ];

            \App\Models\User::create($item);
            $item1 = [
           
                'R_id'=>1,
                'f_name'=>'feras',
                'L_name'=>'khalil',
                'email'=>'feras@gmail.com',
                'password'=>bcrypt('feras1234')
            
                    ];
            \App\Models\employee::create($item1);

        
    }
    }

