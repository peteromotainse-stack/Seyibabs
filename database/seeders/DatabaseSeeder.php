<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\SocialHandle;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $bubee = User::create([
            'name'              => 'Bubee Wetaract',
            'username'          => 'bubee',
            'email'             => 'bubee@wetaract.com',
            'password'          => Hash::make('password'),
            'avatar'            => 'https://picsum.photos/seed/bubee/200',
            'membership_status' => 'ACTIVE',
            'is_elite_verified' => true,
            'points'            => 2450,
            'wallet_balance'    => 125.50,
            'total_withdrawn'   => 450.00,
            'following_count'   => 1240,
            'followers_count'   => 850,
            'interests'         => ['Tech','Music','Travel','Gaming'],
            'referral_code'     => 'BUBEE24',
            'total_referrals'   => 12,
            'referral_earnings' => 120.00,
            'referral_pending'  => 15.00,
            'warnings'          => 0,
            'visibility_score'  => 85,
            'engagement_rate'   => 12.00,
        ]);

        foreach ([
            ['Instagram','@bubee_insta'],
            ['TikTok','@bubee_tiktok'],
            ['Twitter','@bubee_x'],
            ['YouTube','BubeeVlogs'],
            ['Facebook','bubee.official'],
            ['Spotify','bubee_music'],
        ] as [$platform, $handle]) {
            SocialHandle::create(['user_id' => $bubee->id, 'platform' => $platform, 'handle' => $handle]);
        }

        Transaction::create(['user_id' => $bubee->id, 'type' => 'Earning',        'amount' => 2.50,  'description' => 'Campaign Reward: YouTube View', 'status' => 'Completed']);
        Transaction::create(['user_id' => $bubee->id, 'type' => 'Withdrawal',     'amount' => 50.00, 'description' => 'Bank Transfer',                 'status' => 'Completed']);
        Transaction::create(['user_id' => $bubee->id, 'type' => 'Campaign_Spend', 'amount' => 10.00, 'description' => 'New Campaign: Instagram Like',   'status' => 'Completed']);

        $memberData = [
            ['Elena Gilbert',   'elenag',    'elena',   'ACTIVE',   true,  4500, ['Tech','Gadgets','Lifestyle']],
            ['Damon Salvatore', 'damons',    'damon',   'ACTIVE',   true,  3200, ['Cars','Music','Tech']],
            ['Stefan Salvatore','stefans',   'stefan',  'ACTIVE',   true,  5100, ['Books','Health','Cooking']],
            ['Bonnie Bennett',  'bonnieb',   'bonnie',  'INACTIVE', false, 2800, ['Music','Art','Tech']],
            ['Caroline Forbes', 'carolinef', 'caroline','INACTIVE', false, 1900, ['Lifestyle','Beauty','Fashion']],
        ];

        $members = [];
        foreach ($memberData as [$name, $username, $seed, $status, $elite, $points, $interests]) {
            $members[$username] = User::create([
                'name'              => $name,
                'username'          => $username,
                'email'             => $username . '@wetaract.com',
                'password'          => Hash::make('password'),
                'avatar'            => 'https://picsum.photos/seed/' . $seed . '/200',
                'membership_status' => $status,
                'is_elite_verified' => $elite,
                'points'            => $points,
                'wallet_balance'    => rand(10, 200),
                'interests'         => $interests,
                'referral_code'     => strtoupper(substr($username, 0, 6) . rand(10, 99)),
                'visibility_score'  => rand(40, 95),
                'engagement_rate'   => rand(5, 20),
            ]);
        }

        Campaign::create(['user_id' => $members['elenag']->id, 'platform' => 'Instagram', 'action_type' => 'Like',   'link' => 'https://instagram.com/p/123', 'description' => 'Check out my latest travel photography from Bali! Would appreciate the love.', 'total_slots' => 100, 'remaining_slots' => 45, 'reward_type' => 'Points', 'reward_value' => 50,   'campaign_type' => 'Reciprocity', 'creator_interests' => ['Travel','Photography','Lifestyle']]);
        Campaign::create(['user_id' => $members['damons']->id, 'platform' => 'YouTube',   'action_type' => 'View',   'link' => 'https://youtube.com/watch?v=paid-video', 'description' => 'Watch our new product launch video for at least 3 minutes to earn real cash reward!', 'total_slots' => 500, 'remaining_slots' => 240, 'reward_type' => 'Cash',   'reward_value' => 2.50, 'campaign_type' => 'Paid',        'use_ai' => true, 'creator_interests' => ['Tech','Business','Marketing']]);
        Campaign::create(['user_id' => $members['elenag']->id, 'platform' => 'YouTube',   'action_type' => 'Play',   'link' => 'https://youtube.com/watch?v=456', 'description' => 'New track just dropped! Please play and stream for at least 60 seconds.', 'total_slots' => 500, 'remaining_slots' => 10,  'reward_type' => 'Points', 'reward_value' => 150,  'campaign_type' => 'Reciprocity', 'creator_interests' => ['Music','Nightlife','Tech']]);
        Campaign::create(['user_id' => $members['damons']->id, 'platform' => 'Twitter',   'action_type' => 'Repost', 'link' => 'https://twitter.com/gamehub/status/123', 'description' => 'Repost our latest giveaway post to win a PS5 and earn instant cash.', 'total_slots' => 100, 'remaining_slots' => 15,  'reward_type' => 'Cash',   'reward_value' => 1.00, 'campaign_type' => 'Paid',        'target_location' => 'USA', 'creator_interests' => ['Gaming','Tech','Entertainment']]);
    }
}
