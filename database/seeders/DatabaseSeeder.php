<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(TestSeeder::class);
        // $this->call(ProductsTableSeeder::class);
        // $this->call(ProductImagesTableSeeder::class);
        // $this->call(AdvantagesTableSeeder::class);
        // $this->call(BlogsTableSeeder::class);
        // $this->call(BlogImagesTableSeeder::class);
        // $this->call(CertificatesTableSeeder::class);
        // $this->call(CharacteristicsTableSeeder::class);
        // $this->call(FaqsTableSeeder::class);
        // $this->call(ModificationsTableSeeder::class);
        // $this->call(ModificationCharacteristicsTableSeeder::class);
        // $this->call(ProjectsTableSeeder::class);
        // $this->call(ProjectImagesTableSeeder::class);
        // $this->call(UsagesTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
    }
}
