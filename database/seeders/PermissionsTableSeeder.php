<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 9,
                'name' => 'creer-tableau de bord',
                'guard_name' => 'web',
                'module_id' => 12300199591,
                'created_at' => '2025-04-23 09:06:13',
                'updated_at' => '2025-04-23 09:06:13',
            ),
            1 => 
            array (
                'id' => 10,
                'name' => 'voir-tableau de bord',
                'guard_name' => 'web',
                'module_id' => 12300199591,
                'created_at' => '2025-04-23 09:06:13',
                'updated_at' => '2025-04-23 09:06:13',
            ),
            2 => 
            array (
                'id' => 11,
                'name' => 'modifier-tableau de bord',
                'guard_name' => 'web',
                'module_id' => 12300199591,
                'created_at' => '2025-04-23 09:06:13',
                'updated_at' => '2025-04-23 09:06:13',
            ),
            3 => 
            array (
                'id' => 12,
                'name' => 'supprimer-tableau de bord',
                'guard_name' => 'web',
                'module_id' => 12300199591,
                'created_at' => '2025-04-23 09:06:13',
                'updated_at' => '2025-04-23 09:06:13',
            ),
        ));
        
        
    }
}