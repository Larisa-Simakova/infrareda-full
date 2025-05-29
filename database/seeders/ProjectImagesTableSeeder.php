<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProjectImagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('project_images')->delete();
        
        \DB::table('project_images')->insert(array (
            0 => 
            array (
                'id' => 36,
                'url' => 'objects/68312298b755f.jpg',
                'project_id' => 14,
                'created_at' => '2025-05-24 01:36:26',
                'updated_at' => '2025-05-24 01:36:26',
            ),
            1 => 
            array (
                'id' => 37,
                'url' => 'objects/68312298be4b6.jpg',
                'project_id' => 14,
                'created_at' => '2025-05-24 01:36:26',
                'updated_at' => '2025-05-24 01:36:26',
            ),
            2 => 
            array (
                'id' => 38,
                'url' => 'objects/68312298bed39.jpg',
                'project_id' => 14,
                'created_at' => '2025-05-24 01:36:26',
                'updated_at' => '2025-05-24 01:36:26',
            ),
            3 => 
            array (
                'id' => 40,
                'url' => 'objects/683124e41024e.jpg',
                'project_id' => 16,
                'created_at' => '2025-05-24 01:46:14',
                'updated_at' => '2025-05-24 01:46:14',
            ),
            4 => 
            array (
                'id' => 41,
                'url' => 'objects/683124e41383c.jpg',
                'project_id' => 16,
                'created_at' => '2025-05-24 01:46:14',
                'updated_at' => '2025-05-24 01:46:14',
            ),
            5 => 
            array (
                'id' => 42,
                'url' => 'objects/68312535e0343.jpg',
                'project_id' => 17,
                'created_at' => '2025-05-24 01:47:35',
                'updated_at' => '2025-05-24 01:47:35',
            ),
            6 => 
            array (
                'id' => 43,
                'url' => 'objects/68312535e2f71.jpg',
                'project_id' => 17,
                'created_at' => '2025-05-24 01:47:35',
                'updated_at' => '2025-05-24 01:47:35',
            ),
            7 => 
            array (
                'id' => 44,
                'url' => 'objects/683125e43af8f.jpg',
                'project_id' => 18,
                'created_at' => '2025-05-24 01:50:29',
                'updated_at' => '2025-05-24 01:50:29',
            ),
            8 => 
            array (
                'id' => 45,
                'url' => 'objects/683125e43ddad.jpg',
                'project_id' => 18,
                'created_at' => '2025-05-24 01:50:29',
                'updated_at' => '2025-05-24 01:50:29',
            ),
            9 => 
            array (
                'id' => 46,
                'url' => 'objects/6831266388637.jpg',
                'project_id' => 19,
                'created_at' => '2025-05-24 01:52:37',
                'updated_at' => '2025-05-24 01:52:37',
            ),
            10 => 
            array (
                'id' => 47,
                'url' => 'objects/683126638b5ae.jpg',
                'project_id' => 19,
                'created_at' => '2025-05-24 01:52:37',
                'updated_at' => '2025-05-24 01:52:37',
            ),
        ));
        
        
    }
}