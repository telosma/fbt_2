<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@bookingtour.vn',
            'password' => 'admin',
            'role' => config('user.role.admin'),
            'avatar_link' => asset(config('upload.default_folder_path') . config('asset.default_avatar')),
            'type' => config('user.type.normal_user'),
        ]);
    }
}
