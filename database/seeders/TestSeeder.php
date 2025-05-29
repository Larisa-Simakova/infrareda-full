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

        DB::table('products')->insert([
            'id' => 999,
            'title' => 'Test Product',
            'description' => '<p id="isPasted" class="paragraph-normal">Инфракрасные панели ТПИ-Э &ndash; это современная альтернатива традиционным системам отопления...</p>',
            'short_description' => 'This is a test product',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::info("✅ TestSeeder completed");
    }
}
