<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Wedding;
use App\Models\Tentative;
use App\Models\BankQr;
use App\Models\Rsvp;
use App\Models\Photo;
use App\Models\User;

class WeddingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    // Get our fixed wedder
    $wedder = User::where('email', 'wedder@test.com')->first();

    // Create wedding for fixed wedder
    $wedding = Wedding::factory()->create([
        'wedder_id' => $wedder->id,
    ]);

    // Create tentatives for the wedding
    $schedule = [
        ['time' => '2:00 PM', 'title' => 'Guest Arrival',      'note' => 'Please arrive early'],
        ['time' => '3:00 PM', 'title' => 'Wedding Ceremony',    'note' => null],
        ['time' => '4:00 PM', 'title' => 'Photo Session',       'note' => null],
        ['time' => '5:00 PM', 'title' => 'Dinner Begins',       'note' => 'Buffet style'],
        ['time' => '7:00 PM', 'title' => 'Cake Cutting',        'note' => null],
        ['time' => '9:00 PM', 'title' => 'End of Event',        'note' => 'Thank you for coming!'],
    ];

    foreach ($schedule as $item) {
        Tentative::factory()->create([
            'wedding_id'   => $wedding->id,
            'time'         => $item['time'],
            'title'        => $item['title'],
            'note'         => $item['note'],
            'is_published' => true,
        ]);
    }

    // Create bank QR for the wedding
    BankQr::factory()->create([
        'wedding_id' => $wedding->id,
    ]);

    // Create RSVPs — some attending, some not
    $visitors = User::where('role', 'visitor')->get();
    foreach ($visitors as $visitor) {
        Rsvp::factory()->create([
            'wedding_id' => $wedding->id,
            'visitor_id' => $visitor->id,
        ]);
    }

    // Create some photos from attending visitors
    $attendingVisitors = Rsvp::where('wedding_id', $wedding->id)
                              ->where('attendance', 'attending')
                              ->pluck('visitor_id');

    foreach ($attendingVisitors as $visitorId) {
        Photo::factory()->count(rand(1, 3))->create([
            'wedding_id' => $wedding->id,
            'visitor_id' => $visitorId,
        ]);
    }
}
}
