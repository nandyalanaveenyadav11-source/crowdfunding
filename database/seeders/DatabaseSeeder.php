<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        \App\Models\User::updateOrCreate(
            ['role' => 'admin'],
            [
                'name' => 'Admin User',
                'email' => 'admincrowdfund@gmail.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
            ]
        );

        // Regular User
        $user = \App\Models\User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'John Doe',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'user',
            ]
        );

        // Sample Campaigns
        \App\Models\Campaign::updateOrCreate(
            ['title' => 'Clean Water Initiative'],
            [
                'user_id' => $user->id,
                'description' => 'Providing clean and safe drinking water for rural communities in Africa. Your donation helps build wells and filtration systems.',
                'goal_amount' => 10000,
                'current_amount' => 2500,
                'deadline' => now()->addDays(30),
                'status' => 'approved',
                'category' => 'Community',
            ]
        );

        \App\Models\Campaign::updateOrCreate(
            ['title' => 'The Next-Gen Smart Watch'],
            [
                'user_id' => $user->id,
                'description' => 'A revolutionary smart watch with 30-day battery life and advanced health tracking sensors. Join us in shaping the future of wearables.',
                'goal_amount' => 50000,
                'current_amount' => 12000,
                'deadline' => now()->addDays(45),
                'status' => 'approved',
                'category' => 'Technology',
            ]
        );

        \App\Models\Campaign::updateOrCreate(
            ['title' => 'Community Urban Garden'],
            [
                'user_id' => $user->id,
                'description' => 'Help us transform an empty lot into a thriving community garden that provides fresh produce to local families in need.',
                'goal_amount' => 5000,
                'current_amount' => 0,
                'deadline' => now()->addDays(20),
                'status' => 'pending',
                'category' => 'Environment',
            ]
        );
    }
}
