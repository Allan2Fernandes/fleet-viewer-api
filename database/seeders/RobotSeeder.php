<?php

namespace Database\Seeders;

use App\Models\Robot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RobotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['Picker', 'Hauler'];
        $robots = [];
        for ($i=0; $i < 100; $i++) { 
            
            $robots[] = [
                'id' => 'r' . $i,
                'type' => $types[array_rand($types)],
            ];
        }

        Robot::factory()->createMany($robots);
    }
}
