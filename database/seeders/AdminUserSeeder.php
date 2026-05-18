<?php

namespace Database\Seeders;

use App\Models\AdmUser;
use App\Models\AdmUserDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed a test admin account.
     */
    public function run(): void
    {
        $admin = AdmUser::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Test Admin',
                'mobile' => '9999999999',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'status' => 'active',
                'is_active' => 1,
                'is_locked' => 0,
                'is_deleted' => 0,
                'email_verified_at' => now(),
                'password_last_changed_at' => now(),
                'account_created_at' => now(),
            ]
        );

        AdmUserDetail::updateOrCreate(
            ['user_id' => $admin->id],
            [
                'address' => '123 Admin Street',
                'phone_number' => '9999999999',
                'city' => 'New Delhi',
                'state' => 'Delhi',
                'country' => 'India',
                'postal_code' => '110001',
                'timezone' => 'Asia/Kolkata',
                'language' => 'en',
                'date_of_birth' => '1990-01-01',
            ]
        );
    }
}
