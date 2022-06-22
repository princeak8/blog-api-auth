<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Akachukwu Aneke",
            'email' => "akalodave@gmail.com",
            'password' => bcrypt("akalo123"),
            'role' => "admin",
        ]);
    }
}
