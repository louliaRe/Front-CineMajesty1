<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [ 'name' => 'Regular'],
            [ 'name' => 'IMAX'],
            [ 'name' => 'VIP'],
            [ 'name' => '3D'],
            [ 'name' => '4D'],
            [ 'name' => 'GOld'],
            [ 'name' => 'Theatre'],
            [ 'name' => 'Outdoor'],
            [ 'name' => 'VR'],
          

        ];

        foreach ($items as $item) {
            \App\Models\Type::create($item);
        }
    }
}
