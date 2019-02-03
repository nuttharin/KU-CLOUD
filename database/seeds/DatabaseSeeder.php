<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);

        $path = 'app/Provinces/provinces.sql';
        DB::unprepared(file_get_contents($path));
    }
}
