<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TestSeeder extends Seeder
{
    public function run()
    {
        Log::info("🧪 TestSeeder started");

        try {
            DB::table('products')->insert([
                'id' => 999,
                'title' => 'Test Product',
                'short_description' => 'This is a test product description.',
                'description' => '<p>This is a test product description.</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Log::info("✅ TestSeeder successfully inserted data");
        } catch (\Exception $e) {
            Log::error("🔥 TestSeeder failed: " . $e->getMessage());
        }
    }
}
