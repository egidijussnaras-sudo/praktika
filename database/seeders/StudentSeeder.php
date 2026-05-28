<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ši eilutė sukurs 1000 netikrų studentų duomenų bazėje
        Student::factory()->count(1000)->create();
    }
}