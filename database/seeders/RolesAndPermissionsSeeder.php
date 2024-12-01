<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Xóa cache của Spatie
         app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

         // Tạo hoặc lấy quyền hạn
         $manageUsers = Permission::firstOrCreate(['name' => 'manage users']);
         $manageContent = Permission::firstOrCreate(['name' => 'manage content']);
         $viewAnalytics = Permission::firstOrCreate(['name' => 'view analytics']);
 
         // Tạo hoặc lấy vai trò admin và gán quyền
         $admin = Role::firstOrCreate(['name' => 'admin']);
         $admin->syncPermissions([$manageUsers, $manageContent, $viewAnalytics]);
 
         // Tạo hoặc lấy vai trò moderator và gán quyền
         $moderator = Role::firstOrCreate(['name' => 'moderator']);
         $moderator->syncPermissions([$manageContent]);
 
         // Tạo hoặc lấy vai trò user
         $user = Role::firstOrCreate(['name' => 'user']);
         // Người dùng thông thường không cần gán quyền đặc biệt
    }
}
