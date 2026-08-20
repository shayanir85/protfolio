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
                'password' => Hash::make('admin'),
            ]
        );

        // 2. Theme Settings
        ThemeSetting::updateOrCreate(
            ['id' => 1],
            [
                'primary_color' => '#667eea',
                'secondary_color' => '#764ba2',
                'accent_color' => '#06b6d4',
                'gradient_start' => '#667eea',
                'gradient_end' => '#764ba2',
                'gradient_angle' => '135deg',
                'dark_primary_color' => '#818cf8',
                'dark_secondary_color' => '#a78bfa',
                'is_active' => true,
            ]
        );

        // 3. Hero Section Builder Data
        HeroSection::updateOrCreate(
            ['id' => 1],
            [
                'greeting' => 'سلام، من',
                'name' => 'شایان ایران‌پور',
                'title' => 'توسعه‌دهنده فول‌استک و متخصص بک‌اند لاراول',
                'badge_text' => 'آماده همکاری و استخدام (Available for hire)',
                'show_availability' => true,
                'availability_status' => 'available',
                'availability_pulse' => true,
                'enable_typewriter' => true,
                'typewriter_prefix' => 'یک ',
                'typewriter_strings' => [
                    'توسعه‌دهنده بک‌اند لاراول (Laravel Backend Dev)',
                    'علاقه‌مند به معماری تمیز و مقیاس‌پذیر',
                    'مهندس نرم‌افزار و علاقه‌مند به کد تمیز',
                    'سازنده APIهای سریع و استاندارد RESTful',
                ],
                'typewriter_speed' => 75,
                'typewriter_delete_speed' => 35,
                'typewriter_delay' => 2200,
                'description' => 'دانشجوی مهندسی کامپیوتر که علاقه‌مند به ساخت اپلیکیشن‌های وب مدرن، پایدار و مقیاس‌پذیر با <bdi class="en-inline">Laravel & PHP</bdi> و فریم‌ورک‌های مدرن فرانت‌اند مانند <bdi class="en-inline">Vue 3 / Quasar</bdi> است.',
                'buttons' => [
                    [
                        'label' => 'مشاهده نمونه کارها',
                        'action_type' => 'scroll',
                        'target' => 'projects',
                        'variant' => 'primary_gradient',
                        'icon_right' => 'arrow_forward',
                        'size' => 'lg',
                        'new_tab' => false,
                    ],
                    [
                        'label' => 'ارتباط با من',
                        'action_type' => 'scroll',
                        'target' => 'contact',
                        'variant' => 'outline',
                        'icon' => 'mail',
                        'size' => 'lg',
                        'new_tab' => false,
                    ],
                ],
                'stats' => [
                    ['label' => 'سال تجربه و یادگیری', 'value' => 3, 'suffix' => '+'],
                    ['label' => 'پروژه تکمیل شده', 'value' => 14, 'suffix' => '+'],
                    ['label' => 'رضایت و تعهد کاری', 'value' => 100, 'suffix' => '%'],
                ],
                'show_scroll_indicator' => true,
                'scroll_indicator_text' => 'اسکرول کنید',
                'is_active' => true,
            ]
        );

        // 4. About Me Section
        AboutMe::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'درباره من',
                'subtitle' => 'مسیر یادگیری و انگیزه من',
                'content' => '<p>سلام! من <strong>شایان ایران‌پور</strong> هستم، توسعه‌دهنده مشتاق بک‌اند با تخصص اصلی در اکوسیستم <strong>PHP و Laravel</strong>.</p><p>از حل چالش‌های پیچیده نرم‌افزاری، طراحی دیتابیس‌های بهینه، نوشتن کوئری‌های کارآمد و ساخت سیستم‌های امن و پرسرعت لذت می‌برم. همواره در حال یادگیری فناوری‌های جدید و بهبود مهارت‌های فردی و تیمی هستم.</p>',
                'is_active' => true,
            ]
        );

        // 5. Goals ("اهداف من")
        $goalsData = [
            ['text' => 'رسیدن به سطح ارشد توسعه بک‌اند لاراول و تسلط بر میکروسرویس‌ها', 'icon' => 'emoji_events', 'sort_order' => 1],
            ['text' => 'مشارکت موثر در پروژه‌های متن‌باز اکوسیستم لاراول و گیت‌هاب', 'icon' => 'groups', 'sort_order' => 2],
            ['text' => 'توسعه پروژه‌های مقیاس‌پذیر واقعی در سطح بین‌المللی', 'icon' => 'rocket_launch', 'sort_order' => 3],
            ['text' => 'اشتراک‌گذاری دانش و مقالات تخصصی در لینکدین و گیت‌هاب', 'icon' => 'share', 'sort_order' => 4],
        ];

        foreach ($goalsData as $g) {
            Goal::updateOrCreate(
                ['text' => $g['text']],
                [
                    'icon' => $g['icon'],
                    'sort_order' => $g['sort_order'],
                    'is_active' => true,
                ]
            );
        }

        // 6. Experience Timeline
        $experiences = [
            [
                'title' => 'فریلنسر / خوداشتغال',
                'position' => 'توسعه‌دهنده بک‌اند لاراول (Laravel Developer)',
                'explanation' => "طراحی و توسعه پنل‌های مدیریتی پیشرفته با Filament 3\nپیاده‌سازی APIهای RESTful با احراز هویت Sanctum\nبهینه‌سازی کوئری‌های دیتابیس MySQL و کش با Redis",
                'start_date' => '2024-01-01',
                'end_date' => null,
            ],
            [
                'title' => 'دانشگاه مهندسی',
                'position' => 'دانشجوی مهندسی کامپیوتر',
                'explanation' => "مطالعه مفاهیم سیستم‌های عامل، شبکه‌های کامپیوتری و ساختار داده‌ها\nتمرکز بر اصول کد تمیز (Clean Code) و الگوهای طراحی (Design Patterns)",
                'start_date' => '2023-09-23',
                'end_date' => null,
            ],
        ];

        foreach ($experiences as $exp) {
            Experience::updateOrCreate(
                ['title' => $exp['title'], 'position' => $exp['position']],
                $exp
            );
        }

        // 7. Categories & Skills
        $categoriesData = [
            [
                'name' => 'توسعه بک‌اند (Backend)',
                'skills' => [
                    ['name' => 'PHP', 'level' => SkillLevel::expert],
                    ['name' => 'Laravel', 'level' => SkillLevel::expert],
                    ['name' => 'MySQL', 'level' => SkillLevel::expert],
                    ['name' => 'RESTful APIs', 'level' => SkillLevel::expert],
                    ['name' => 'Redis', 'level' => SkillLevel::intermediate],
                ],
            ],
            [
                'name' => 'توسعه فرانت‌اند (Frontend)',
                'skills' => [
                    ['name' => 'Vue.js 3', 'level' => SkillLevel::intermediate],
                    ['name' => 'Quasar Framework', 'level' => SkillLevel::intermediate],
                    ['name' => 'JavaScript (ES6+)', 'level' => SkillLevel::midLevel],
                    ['name' => 'HTML5 / CSS3 / Tailwind', 'level' => SkillLevel::expert],
                ],
            ],
            [
                'name' => 'ابزارها و DevOps (Tools & Workflow)',
                'skills' => [
                    ['name' => 'Git & GitHub', 'level' => SkillLevel::expert],
                    ['name' => 'Docker', 'level' => SkillLevel::beginner],
                    ['name' => 'Linux / Ubuntu Server', 'level' => SkillLevel::intermediate],
                    ['name' => 'Filament PHP', 'level' => SkillLevel::expert],
                    ['name' => 'Postman', 'level' => SkillLevel::expert],
                ],
            ],
        ];

        foreach ($categoriesData as $catData) {
            $category = Categories::updateOrCreate(
                [
                    'name' => $catData['name'],
                    'user_id' => $user->id,
                ]
            );

            foreach ($catData['skills'] as $skillData) {
                Skills::updateOrCreate(
                    [
                        'name' => $skillData['name'],
                        'category_id' => $category->id,
                    ],
                    [
                        'level' => $skillData['level'],
                    ]
                );
            }
        }

        // 8. GitHub Repos (Curated showcase projects)
        $repos = [
            [
                'full_name' => 'shayan/portfolio-cms',
                'html_url' => 'https://github.com/shayaniranpor/portfolio-cms',
                'description' => 'پلتفرم پورتفولیو داینامیک کامل ساخته شده با Laravel 11، Filament 3 و Quasar Framework با پشتیبانی از چندزبانه و سازنده صفحه.',
                'ssh_url' => 'git@github.com:shayaniranpor/portfolio-cms.git',
                'stargazers_count' => 18,
                'watchers_count' => 18,
                'forks_count' => 4,
                'pushed_at' => now()->toIso8601String(),
                'show' => true,
            ],
            [
                'full_name' => 'shayan/laravel-api-boilerplate',
                'html_url' => 'https://github.com/shayaniranpor/laravel-api-boilerplate',
                'description' => 'قالب آماده ساخت سریع APIهای امن لاراول با احراز هویت Sanctum، مستندسازی خودکار Swagger و مدیریت رول‌ها.',
                'ssh_url' => 'git@github.com:shayaniranpor/laravel-api-boilerplate.git',
                'stargazers_count' => 12,
                'watchers_count' => 12,
                'forks_count' => 2,
                'pushed_at' => now()->subDays(5)->toIso8601String(),
                'show' => true,
            ],
            [
                'full_name' => 'shayan/quasar-portfolio-frontend',
                'html_url' => 'https://github.com/shayaniranpor/quasar-portfolio-frontend',
                'description' => 'قالب مدرن وب‌سایت شخصی با Vue 3، تم‌های تیره/روشن، انیمیشن‌های روان و پشتیبانی کامل راست‌چین (RTL).',
                'ssh_url' => 'git@github.com:shayaniranpor/quasar-portfolio-frontend.git',
                'stargazers_count' => 9,
                'watchers_count' => 9,
                'forks_count' => 1,
                'pushed_at' => now()->subDays(12)->toIso8601String(),
                'show' => true,
            ],
        ];

        foreach ($repos as $repo) {
            GithubRepo::updateOrCreate(
                ['full_name' => $repo['full_name']],
                array_merge($repo, ['user_id' => $user->id])
            );
        }

        // 9. Social Links
        $socials = [
            ['social_link' => 'https://github.com/shayaniranpor', 'social_media_name' => SocialMediaName::GitHub],
            ['social_link' => 'https://linkedin.com/in/shayaniranpor', 'social_media_name' => SocialMediaName::LinkedIn],
            ['social_link' => 'https://website.com/shayaniranpor', 'social_media_name' => SocialMediaName::Website],
        ];

        foreach ($socials as $social) {
            SocialLinks::updateOrCreate(
                ['social_link' => $social['social_link'], 'user_id' => $user->id],
                ['social_media_name' => $social['social_media_name']]
            );
        }

        // 10. Sample Contact Message
        Contact::updateOrCreate(
            ['phone' => '09123456789'],
            [
                'name' => 'همکار گرامی',
                'message' => 'سلام، پورتفولیو و نمونه کارهای شما را دیدم و مایل به همکاری در توسعه یک پروژه بک‌اند با لاراول هستم.',
            ]
        );
    }
}
