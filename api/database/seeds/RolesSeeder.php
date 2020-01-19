<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'role_name' => 'Admin',
                'role_description' => 'DefaultTheme'
                //'role_created_at'
            ],
        ]);
    }

//$table->bigIncrements('role_id');
//$table->string('role_name');
//$table->string('role_description')->nullable();
//$table->dateTime('role_created_at');
//$table->dateTime('role_updated_at');
}
