<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 1)->create([
            'name' => 'Rodrigo Caetano',
            'email' => 'capacitaciones.zen@gmail.com',
            'password' => bcrypt('admin123'),
        ]);

        factory(User::class, 4)->create();
    }
}
