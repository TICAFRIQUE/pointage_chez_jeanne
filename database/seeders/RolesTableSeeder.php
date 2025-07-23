<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'administrateur',
                'guard_name' => 'web',
                'created_at' => '2025-04-22 08:40:37',
                'updated_at' => '2025-04-22 08:57:57',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'developpeur',
                'guard_name' => 'web',
                'created_at' => '2025-04-22 08:40:46',
                'updated_at' => '2025-04-22 08:40:46',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'superadmin',
                'guard_name' => 'web',
                'created_at' => '2025-04-23 08:47:08',
                'updated_at' => '2025-04-23 08:47:08',
            ),
        ));
        
        
    }
}