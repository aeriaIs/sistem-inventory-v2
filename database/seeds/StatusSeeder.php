<?php

use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('statuses')->insert([
        	0 => [
                'id' 		=> 1,
                'name' 		=> 'Pending',
                'created_at'=> '2021-01-07 08:27:30',
            ],

            1 => [
                'id' 		=> 2,
                'name' 		=> 'Completed',
                'created_at'=> '2021-01-07 08:27:30',
            ],

        ]);
    }
}
