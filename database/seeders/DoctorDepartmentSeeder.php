<?php

namespace Database\Seeders;

use App\Models\DoctorDepartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            'Cardiology',
            'Neurology',
            'Pediatrics',
            'Orthopedics',
            'Dermatology',
            'Gynecology',
            'Psychiatry',
            'Radiology',
            'ENT'
        ];

        foreach ($departments as $department) {
            DoctorDepartment::create(['name' => $department]);
        }
    }
}
