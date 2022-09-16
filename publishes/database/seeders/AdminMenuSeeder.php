<?php

namespace Database\Seeders;

use App\Models\AdminMenu;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdminMenu::all()->map(function ($item) {
            $item->delete();
        });
        Role::all()->map(function ($item) {
            $item->delete();
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Role::truncate();
        AdminMenu::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        Role::create([
            "name" => "administrator"
            , "title" => "Administrator"
        ]);
        Role::create([
            "name" => "developer"
            , "title" => "Developer"
        ]);
        Role::create([
            "name" => "creator"
            , "title" => "Creator"
        ]);
        Role::create([
            "name" => "seller"
            , "title" => "Seller"
        ]);
        // ad all permission to Administrator

        $role = Role::whereName("administrator")->first();
        if ($role) {
            $per = Permission::all()->pluck("id");
            $role->resetPermissions($per);
        }


        //  if (AdminMenu::count() <= 0) {



        $parent = AdminMenu::create([
            "route" => "admin.auth"
            , "name" => "Auth"
            , "parent_id" => 0
            , "icon" => "assignment"
        ]);
        if ($parent) {
            $parent->roles()->save($role);
        }
        $menu = AdminMenu::create([
            "route" => "admin.auth.roles"
            , "name" => "Roles"
            , "parent_id" => $parent->id
            , "sort" => 1
            , "icon" => "security"
        ]);
        if ($menu) {
            $menu->roles()->save($role);
        }
        unset($menu);
        $menu = AdminMenu::create([
            "route" => "admin.auth.permissions"
            , "name" => "Permissions"
            , "parent_id" => $parent->id
            , "sort" => 2
            , "icon" => "verified"
        ]);

        if ($menu) {
            $menu->roles()->save($role);
        }
        unset($menu);
        $menu = AdminMenu::create([
            "route" => "admin.auth.admin-menus"
            , "name" => "Admin Menus"
            , "parent_id" => $parent->id
            , "sort" => 3
            , "icon" => "menu"
        ]);
        if ($menu) {
            $menu->roles()->save($role);
        }
        unset($menu);
        $menu = AdminMenu::create([
            "route" => "admin.auth.admins"
            , "name" => "Admin Users"
            , "parent_id" => $parent->id
            , "sort" => 4
            , "icon" => "people"
        ]);
        if ($menu) {
            $menu->roles()->save($role);
        }
    }
    // }
}
