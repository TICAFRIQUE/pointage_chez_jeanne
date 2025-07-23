<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ModulesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('modules')->delete();
        
        \DB::table('modules')->insert(array (
            0 => 
            array (
                'id' => 12300199591,
                'name' => 'tableau de bord',
                'slug' => 'tableau-de-bord',
                'deleted_at' => NULL,
                'created_at' => '2025-04-23 09:06:13',
                'updated_at' => '2025-04-23 09:06:13',
            ),
        ));
        
        
    }
}