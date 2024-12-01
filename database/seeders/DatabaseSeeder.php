<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
        public function run()
    {
        // Gọi seeder vai trò và quyền
        $this->call(RolesAndPermissionsSeeder::class);

        // Tạo tài khoản quản trị viên
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        $admin->assignRole('admin');

        // Tạo tài khoản Quản trị nội dung
        $moderator = User::create([
            'name' => 'Moderator',
            'email' => 'moderator@gmail.com',
            'password' => bcrypt('123456'),
        ]);
        $moderator->assignRole('moderator');
    }
}
