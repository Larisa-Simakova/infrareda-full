<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ModificationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('modifications')->delete();
        
        \DB::table('modifications')->insert(array (
            0 => 
            array (
                'id' => 32,
            'title' => 'ТПИ28-030 (Zn)',
                'product_id' => 8,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 33,
            'title' => 'ТПИ28-045 (Zn)',
                'product_id' => 8,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 34,
            'title' => 'ТПИ28-060 (Zn)',
                'product_id' => 8,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 35,
            'title' => 'ТПИ28-075 (Zn)',
                'product_id' => 8,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 42,
            'title' => 'ТПИ28-090 (Zn)',
                'product_id' => 8,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 43,
            'title' => 'ТПИ28-105 (Zn)',
                'product_id' => 8,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 44,
            'title' => 'ТПИ28-120 (Zn)',
                'product_id' => 8,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 45,
            'title' => 'ТПИ28-135 (Zn)',
                'product_id' => 8,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 46,
            'title' => 'ТПИ28-150 (Zn)',
                'product_id' => 8,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 47,
            'title' => 'ТПИ28-180 (Zn)',
                'product_id' => 8,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 48,
                'title' => 'ТПИ-Э-250',
                'product_id' => 18,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 49,
                'title' => 'ТПИ-Э-500',
                'product_id' => 18,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 50,
                'title' => 'ТПИ-Э-750',
                'product_id' => 18,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 51,
                'title' => 'ТПИ-Э-1000',
                'product_id' => 18,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}