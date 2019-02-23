<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class ChecklistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1, 10) as $index) {
            DB::table('checklists')->insert([
                'object_domain' => $faker->word,
                'urgency' => '1',
                'description' => $faker->paragraph,
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now()
            ]);
        }
    }
}
