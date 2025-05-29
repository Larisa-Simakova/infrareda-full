<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductImagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('product_images')->delete();
        
        \DB::table('product_images')->insert(array (
            0 => 
            array (
                'id' => 12,
                'url' => 'products/8/OlLeRN2ynSPT7ji5F4uvGGOH4GrkliBJS4NX77bg.png',
                'product_id' => 8,
                'created_at' => '2025-05-22 07:39:35',
                'updated_at' => '2025-05-22 07:39:35',
            ),
            1 => 
            array (
                'id' => 13,
                'url' => 'products/8/uZ7IOtBpy9UoMVEI0vHE8ZKEmNA9GkkZfZeeBeoQ.png',
                'product_id' => 8,
                'created_at' => '2025-05-22 07:39:35',
                'updated_at' => '2025-05-22 07:39:35',
            ),
            2 => 
            array (
                'id' => 31,
                'url' => 'products/18/ARIPEOfNxnaXTxZsB7jvteL6vS0LT8gmIXfouaSV.png',
                'product_id' => 18,
                'created_at' => '2025-05-24 00:20:47',
                'updated_at' => '2025-05-24 00:20:47',
            ),
            3 => 
            array (
                'id' => 32,
                'url' => 'products/19/iqIgUbYYTrcq1yE4IpASotzPEnavmMrRjVBKsMzb.png',
                'product_id' => 19,
                'created_at' => '2025-05-24 00:36:50',
                'updated_at' => '2025-05-24 00:36:50',
            ),
            4 => 
            array (
                'id' => 33,
                'url' => 'products/20/3Y1iYBANXi1RhY2bqoQM7Q94DRORZK0sBad8mNxC.webp',
                'product_id' => 20,
                'created_at' => '2025-05-24 00:51:50',
                'updated_at' => '2025-05-24 00:51:50',
            ),
            5 => 
            array (
                'id' => 34,
                'url' => 'products/21/yH6UcwBX1bF34TIDe1hQbfN73h0yDNqIJk4An9h3.png',
                'product_id' => 21,
                'created_at' => '2025-05-24 00:58:10',
                'updated_at' => '2025-05-24 00:58:10',
            ),
        ));
        
        
    }
}