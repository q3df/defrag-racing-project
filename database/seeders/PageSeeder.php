<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Page::firstOrCreate(
            ['slug' => 'privacy-policy'],
            ['title' => 'Privacy Policy', 'content' => '<p>Initial content...</p>', 'visible' => true, 'footer_link' => true]
        );

        Page::firstOrCreate(
            ['slug' => 'privacy-policy-twitch'],
            ['title' => 'Privacy Policy Twitch', 'content' => '<p>Initial content...</p>', 'visible' => true, 'footer_link' => false]
        );
    }
}
