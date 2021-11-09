<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'id_student' => "RN-001", 
                'student' => "Global School", 
                'created_at' => new \DateTime,
                'updated_at' => null,
            ], 
            [
                'id_student' => "RN-002", 
                'student' => "Global School", 
                'created_at' => new \DateTime,
                'updated_at' => null,
            ],  
    
        ];
    
        \DB::table('student')->insert($roles);
    }
}
