<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [ 'name' => 'Horror'],
            [ 'name' => 'Action'],
            [ 'name' => 'Drama'],
            [ 'name' => 'Sci-fi'],
            [ 'name' => 'Romance'],
            [ 'name' => 'Adventure'],
            [ 'name' => 'Comedy'],
            [ 'name' => 'Fantasy'],
            [ 'name' => 'Musical'],
            [ 'name' => 'Crime'],
            [ 'name' => 'Animation'],
            [ 'name' => 'War'],
            [ 'name' => 'History'],
            [ 'name' => 'Mystery'],

        ];

        foreach ($items as $item) {
            \App\Models\Genre::create($item);
        }
    }
}
