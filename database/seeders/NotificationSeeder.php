<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Notification;
use Carbon\Carbon;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notifications = [
            [
                'feature' => 'New Equipment Arrival',
                'description' => 'New state-of-the-art treadmills and elliptical machines have been installed in the cardio section. Come check them out!',
                'date' => Carbon::now()->subDays(1),
                'is_deleted' => false,
                'is_read' => false
            ],
            [
                'feature' => 'Fitness Class Schedule Update',
                'description' => 'We have updated our fitness class schedule. New Zumba and Pilates classes have been added to the evening slots.',
                'date' => Carbon::now()->subDays(2),
                'is_deleted' => false,
                'is_read' => true
            ],
            [
                'feature' => 'Maintenance Notice',
                'description' => 'Scheduled maintenance for the swimming pool will be conducted on Friday from 2 PM to 6 PM. We apologize for any inconvenience.',
                'date' => Carbon::now()->subDays(3),
                'is_deleted' => false,
                'is_read' => false
            ],
            [
                'feature' => 'Membership Promotion',
                'description' => 'Special 20% discount on annual memberships this month! Limited time offer for new and existing members.',
                'date' => Carbon::now()->subDays(4),
                'is_deleted' => false,
                'is_read' => true
            ],
            [
                'feature' => 'Personal Trainer Availability',
                'description' => 'New certified personal trainers are now available for booking. Get personalized workout plans and achieve your fitness goals faster!',
                'date' => Carbon::now()->subDays(5),
                'is_deleted' => false,
                'is_read' => false
            ],
            [
                'feature' => 'Holiday Schedule',
                'description' => 'The gym will have modified hours during the upcoming holiday weekend. Please check our website for the updated schedule.',
                'date' => Carbon::now()->subDays(6),
                'is_deleted' => false,
                'is_read' => true
            ],
            [
                'feature' => 'Nutrition Workshop',
                'description' => 'Join us this Saturday for a free nutrition workshop. Learn about meal planning and healthy eating habits.',
                'date' => Carbon::now()->subDays(7),
                'is_deleted' => false,
                'is_read' => false
            ]
        ];

        foreach ($notifications as $notification) {
            Notification::create($notification);
        }
    }
}