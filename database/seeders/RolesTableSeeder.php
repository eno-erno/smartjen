<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
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
                'name' => "ADMIN", 
                'created_at' => new \DateTime,
                'updated_at' => null,
            ], 
            [
                'name' => "TEACHER", 
                'created_at' => new \DateTime,
                'updated_at' => null,
            ], 
            [
                'name' => "STUDENT", 
                'created_at' => new \DateTime,
                'updated_at' => null,
            ], 
    
        ];
    
        \DB::table('roles')->insert($roles);
    }
}
