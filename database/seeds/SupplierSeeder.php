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
    	\DB::table('suppliers')->insert([
        	0 => [
                'id' 		=> 1,
                'name' 		=> 'PT. Sumber Maruk',
                'slug' 		=> 'pt-sumber-maruk',
                'address' 	=> 'Cibubur, Jakarta Timur',
                'phone' 	=> '',
                'created_at'=> '2021-01-07 08:27:30',
            ],

            1 => [
                'id' 		=> 2,
                'name' 		=> 'PT. Angkasa Jaya',
                'slug' 		=> 'pt-angkasa-jaya',
                'address' 	=> 'Cilegon, Jakarta Utara',
                'phone' 	=> '',
                'created_at'=> '2021-01-07 08:27:30',
            ],

            2 => [
                'id' 		=> 3,
                'name' 		=> 'PT. Dewa Kipas',
                'slug' 		=> 'pt-dewa-kipas',
                'address' 	=> 'Cibubur, Jakarta Timur',
                'phone' 	=> '',
                'created_at'=> '2021-01-07 08:27:30',  
            ],

            3 => [
                'id' 		=> 4,
                'name' 		=> 'PT. Orang Tua',
                'slug' 		=> 'pt-orang-tua',
                'address' 	=> 'Jakarta Pusat',
                'phone' 	=> '',
                'created_at'=> '2021-01-07 08:27:30',
            ],

            4 => [
                'id' 		=> 5,
                'name' 		=> 'PT. Kadal Gurun',
                'slug' 		=> 'pt-kadal-gurun',
                'address' 	=> 'Cibubur, Jakarta Timur',
                'phone' 	=> '',
                'created_at'=> '2021-01-07 08:27:30',
            ],

        ]);
    }
}
