<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CertificatesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('certificates')->delete();
        
        \DB::table('certificates')->insert(array (
            0 => 
            array (
                'id' => 16,
                'url' => 'products/8/certificates/3XIHQiaPuHm0ORo4qi3a4JrjUoG0v2JB5kOtRRK5.pdf',
                'product_id' => 8,
                'created_at' => '2025-05-23 23:36:46',
                'updated_at' => '2025-05-23 23:36:46',
            ),
            1 => 
            array (
                'id' => 21,
                'url' => 'products/8/certificates/w9NQ6baTp7y7qTcwAqitR0ePOQUNwBnpWrubeOxZ.pdf',
                'product_id' => 8,
                'created_at' => '2025-05-28 06:49:36',
                'updated_at' => '2025-05-28 06:49:36',
            ),
            2 => 
            array (
                'id' => 22,
                'url' => 'products/8/certificates/suIsj5J9yCnscVjTGlPdxTzKQEgXrkFEx27iT4iA.pdf',
                'product_id' => 8,
                'created_at' => '2025-05-28 06:49:36',
                'updated_at' => '2025-05-28 06:49:36',
            ),
            3 => 
            array (
                'id' => 23,
                'url' => 'products/8/certificates/oH2LqIJYsBONiKTpAZdsa5nqPNNjQ5rDmJPyclIN.pdf',
                'product_id' => 8,
                'created_at' => '2025-05-28 06:49:36',
                'updated_at' => '2025-05-28 06:49:36',
            ),
            4 => 
            array (
                'id' => 24,
                'url' => 'products/8/certificates/lVKTitMFTFte69ldp9ZbTJTIptdFEf1ucCiGcfY9.pdf',
                'product_id' => 8,
                'created_at' => '2025-05-28 06:49:36',
                'updated_at' => '2025-05-28 06:49:36',
            ),
        ));
        
        
    }
}