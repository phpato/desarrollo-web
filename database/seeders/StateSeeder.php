<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  App\Models\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        State::create(["name" => "borrador"]);
        State::create(["name" => "publicado"]);
        State::create(["name" => "archivado"]);
    }
}
