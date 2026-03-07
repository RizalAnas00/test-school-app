<?php

namespace Database\Seeders;

use App\Models\AcademicClass;
use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Teacher::factory(20)->create()->each(function ($teacher) {
            $teacher->academicClasses()->attach(
                AcademicClass::inRandomOrder()->take(rand(1,3))->pluck('id')
            );
        });
    }
}
