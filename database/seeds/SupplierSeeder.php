<?php

use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Supplier
    	\DB::table('categories')->insert([
        	0 => [
                'id' 	=> 1,
                'name' 	=> 'Ekonomi',
                'slug' 	=> 'ekonomi',
                'created_at'=> '2021-01-07 08:27:30',
            ],

            1 => [
                'id' 	=> 2,
                'name' 	=> 'Otomotif',
                'slug' 	=> 'motorsport',
                'created_at'=> '2021-01-07 08:27:30'   
            ],

            2 => [
                'id' 	=> 3,
                'name' 	=> 'Olahraga',
                'slug' 	=> 'olahraga',
                'created_at'=> '2021-01-07 08:27:30'   
            ],

            3 => [
                'id' 	=> 4,
                'name' 	=> 'Pendidikan',
                'slug' 	=> 'pendidkan',
                'created_at'=> '2021-01-07 08:27:30'   
            ],

            4 => [
                'id' 	=> 5,
                'name' 	=> 'Politik',
                'slug' 	=> 'politik',
                'created_at'=> '2021-01-07 08:27:30'   
            ],

            5 => [
                'id' 	=> 6,
                'name' 	=> 'Gaya Hidup',
                'slug' 	=> 'gaya-hidup',
                'created_at'=> '2021-01-07 08:27:30'   
            ],

            6 => [
                'id' 	=> 7,
                'name' 	=> 'Bisnis',
                'slug' 	=> 'bisnis',
                'created_at'=> '2021-01-07 08:27:30'   
            ],

        ]);
    }
}
