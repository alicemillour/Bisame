<?php

use Illuminate\Database\Seeder;
use App\Notification;
use App\AdminNotification;

class NotificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Notification::firstOrCreate(['slug' => 'anecdotes', 'is_admin' => '0']);
        Notification::firstOrCreate(['slug' => 'discussions', 'is_admin' => '0']);
        Notification::firstOrCreate(['slug' => 'messages', 'is_admin' => '0']);
        Notification::firstOrCreate(['slug' => 'alterntive-texts', 'is_admin' => '0']);
        Notification::firstOrCreate(['slug' => 'photos', 'is_admin' => '0']);
        Notification::firstOrCreate(['slug' => 'contact', 'is_admin' => '1']);
        Notification::firstOrCreate(['slug' => 'report', 'is_admin' => '1']);
        Notification::firstOrCreate(['slug' => 'all-recipes', 'is_admin' => '1']);
    }
}
