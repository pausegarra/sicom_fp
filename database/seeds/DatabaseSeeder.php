<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        User::create(
            array(
                'name' => 'root',
                'email' => 'it@tecnol.es',
                'password' => Hash::make('LQsLzNTf3U49'),
                'api_token'=> hash('sha256','XxNss39SL959'),
            )
        );
        User::create(
            array(
                'name' => 'test',
                'email' => 'it2@tecnol.es',
                'password' => Hash::make('ZXfH5MckjHmS'),
                'api_token'=> hash('sha256','SRgZuXWsjw6q'),
            )
        );
    }
}
