<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions=[
            ['name'=>'review Approval','rule'=>'Approve review'],
            ['name'=>'rate','rule'=>'Rate film'],
            ['name'=>'watch','rule'=>'Mark film as watched'],
            ['name'=>'like','rule'=>'Mark film as liked'],
            ['name'=>'addUser','rule'=>'Add new users'],
            ['name'=>'editUser','rule'=>'Edit users'],
            ['name'=>'deleteUser','rule'=>'Delete users'],
        ];

        Permission::insert($permissions);
    }
}
