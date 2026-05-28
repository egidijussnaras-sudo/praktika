<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Pirmiausia paleidžiame miestus ir studentus
        $this->call([
            CitySeeder::class,
            StudentSeeder::class,
        ]);

        // Paliekame Jetstream vartotojo kūrimą, kad veiktų prisijungimas
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
