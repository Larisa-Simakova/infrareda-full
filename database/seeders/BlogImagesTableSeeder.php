<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BlogImagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('blog_images')->delete();
        
        \DB::table('blog_images')->insert(array (
            0 => 
            array (
                'id' => 31,
                'url' => 'blog/uNl3kWmYT0DMxxKmERt7FZMT7vlTypYn4OzjenxR.jpg',
                'blog_id' => 13,
                'created_at' => '2025-05-22 06:33:44',
                'updated_at' => '2025-05-22 06:33:44',
            ),
            1 => 
            array (
                'id' => 33,
                'url' => 'blog/HldcCkJY0Tq6chXhlcWZxQJf9xKxviRwNaGL14pb.jpg',
                'blog_id' => 15,
                'created_at' => '2025-05-22 06:57:19',
                'updated_at' => '2025-05-22 06:57:19',
            ),
            2 => 
            array (
                'id' => 34,
                'url' => 'blogs/682ecb703ab42.jpg',
                'blog_id' => 14,
                'created_at' => '2025-05-22 07:00:01',
                'updated_at' => '2025-05-22 07:00:01',
            ),
            3 => 
            array (
                'id' => 37,
                'url' => 'blogs/682ece382920c.png',
                'blog_id' => 16,
                'created_at' => '2025-05-22 07:11:54',
                'updated_at' => '2025-05-22 07:11:54',
            ),
            4 => 
            array (
                'id' => 38,
                'url' => 'blogs/682ece7b563a7.jpg',
                'blog_id' => 17,
                'created_at' => '2025-05-22 07:13:02',
                'updated_at' => '2025-05-22 07:13:02',
            ),
            5 => 
            array (
                'id' => 73,
                'url' => 'blogs/6836a45664326.png',
                'blog_id' => 12,
                'created_at' => '2025-05-28 05:51:20',
                'updated_at' => '2025-05-28 05:51:20',
            ),
        ));
        
        
    }
}