<?php

namespace Database\Seeders;

use App\Enums\SkillLevel;
use App\Enums\SocialMediaName;
use App\Models\AboutMe;
use App\Models\Categories;
use App\Models\Contact;
use App\Models\Experience;
use App\Models\GithubRepo;
use App\Models\Goal;
use App\Models\HeroSection;
use App\Models\Skills;
use App\Models\SocialLinks;
use App\Models\ThemeSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin User
        $user = User::firstOrCreate(
            ['email' => 'shayaniranpor8@gmail.com'],
            [
                'name' => 'Shayan Iranpour',
                'password' => 'sh1385529ayaN',
            ]
        );

    }
}
