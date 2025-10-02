<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Affiliate;
use App\Models\User;

class AffiliateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some users to create affiliate links for
        $users = User::where('role', 'client')->take(5)->get();
        
        if ($users->count() > 0) {
            foreach ($users as $user) {
                // Create 1-3 affiliate links per user
                $linkCount = rand(1, 3);
                
                for ($i = 0; $i < $linkCount; $i++) {
                    Affiliate::create([
                        'user_id' => $user->id,
                        'affiliate_code' => Affiliate::generateAffiliateCode(),
                        'name' => $this->getRandomLinkName(),
                        'description' => $this->getRandomDescription(),
                        'is_active' => rand(0, 1) ? true : false,
                        'total_clicks' => rand(0, 100),
                        'total_conversions' => rand(0, 20),
                    ]);
                }
            }
        }
    }

    private function getRandomLinkName(): string
    {
        $names = [
            'Social Media Campaign',
            'Email Newsletter',
            'Website Banner',
            'YouTube Channel',
            'LinkedIn Post',
            'Facebook Ad',
            'Instagram Story',
            'Twitter Promotion',
            'Blog Post',
            'Partner Referral'
        ];
        
        return $names[array_rand($names)];
    }

    private function getRandomDescription(): string
    {
        $descriptions = [
            'Promoting BINA 2025 on social media platforms',
            'Sharing with professional network on LinkedIn',
            'Email marketing campaign to subscribers',
            'Website banner placement for maximum visibility',
            'YouTube video description and comments',
            'Facebook group and page promotions',
            'Instagram stories and posts',
            'Twitter thread about the event',
            'Blog post about construction industry events',
            'Partner referral program'
        ];
        
        return $descriptions[array_rand($descriptions)];
    }
}