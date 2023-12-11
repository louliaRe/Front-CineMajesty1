<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class roleSeeder extends Seeder
{
    public function run()
    {
        $items = [
            ['r_id' => 1, 'name' => 'admin'],
            ['r_id' => 2, 'name' => 'manager'],
            ['r_id' => 3, 'name' => 'employee'],
            ['r_id' => 4, 'name' => 'customer']
        ];

        foreach ($items as $item) {
            \App\Models\Role::create($item);
        }
    }
}