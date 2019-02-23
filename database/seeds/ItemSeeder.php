<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1, 3) as $index) {
            DB::table('items')->insert([
                'name' => $faker->word,
                'urgency' => '1',
                'checklist_id' => '3',
                'description' => $faker->paragraph,
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now()
            ]);
        }
    }
}
