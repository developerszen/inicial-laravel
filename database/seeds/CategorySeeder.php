<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Category::class, 1)->create([
            'name' => 'Drama',
        ]);

        factory(Category::class, 6)->create();
    }
}
