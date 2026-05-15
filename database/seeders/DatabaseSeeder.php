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
            'interests'         => ['Tech', 'Music', 'Travel', 'Gaming'],
            'referral_code'     => 'BUBEE24',
            'total_referrals'   => 12,
            'referral_earnings' => 120.00,
            'referral_pending'  => 15.00,
            'warnings'          => 0,
            'visibility_score'  => 85,
            'engagement_rate'   => 12.00,
        ]);

        foreach ([
            ['platform' => 'Instagram', 'handle' => '@bubee_insta'],
            ['platform' => 'TikTok',    'handle' => '@bubee_tiktok'],
            ['platform' => 'Twitter',   'handle' => '@bubee_x'],
            ['platform' => 'YouTube',   'handle' => 'BubeeVlogs'],
            ['platform' => 'Facebook',  'handle' => 'bubee.official'],
            ['platform' => 'Spotify',   'handle' => 'bubee_music'],
        ] as $handle) {
            SocialHandle::create(array_merge($handle, ['user_id' => $bubee->id]));
        }

        Transaction::create(['user_id' => $bubee->id, 'type' => 'Earning',       'amount' => 2.50,  'description' => 'Campaign Reward: YouTube View',    'status' => 'Completed']);
        Transaction::create(['user_id' => $bubee->id, 'type' => 'Withdrawal',    'amount' => 50.00, 'description' => 'Bank Transfer',                    'status' => 'Completed']);
        Transaction::create(['user_id' => $bubee->id, 'type' => 'Campaign_Spend','amount' => 10.00, 'description' => 'New Campaign: Instagram Like',      'status' => 'Completed']);

        $members = [
            ['name' => 'Elena Gilbert',   'username' => 'elenag',    'seed' => 'elena',   'status' => 'ACTIVE',   'elite' => true,  'points' => 4500, 'interests' => ['Tech','Gadgets','Lifestyle']],
            ['name' => 'Damon Salvatore', 'username' => 'damons',    'seed' => 'damon',   'status' => 'ACTIVE',   'elite' => true,  'points' => 3200, 'interests' => ['Cars','Music','Tech']],
            ['name' => 'Stefan Salvatore','username' => 'stefans',   'seed' => 'stefan',  'status' => 'ACTIVE',   'elite' => true,  'points' => 5100, 'interests' => ['Books','Health','Cooking']],
            ['name' => 'Bonnie Bennett',  'username' => 'bonnieb',   'seed' => 'bonnie',  'status' => 'INACTIVE', 'elite' => false, 'points' => 2800, 'interests' => ['Music','Art','Tech']],
            ['name' => 'Caroline Forbes', 'username' => 'carolinef', 'seed' => 'caroline','status' => 'INACTIVE', 'elite' => false, 'points' => 1900, 'interests' => ['Lifestyle','Beauty','Fashion']],
        ];

        $memberHandles = [
            'elenag'    => [['Instagram','https://instagram.com/elenag'],['TikTok','https://tiktok.com/@elenag'],['Spotify','elenag_spotify']],
            'damons'    => [['Instagram','https://instagram.com/damons'],['Spotify','damons_spotify']],
            'stefans'   => [['YouTube','https://youtube.com/@stefans'],['Spotify','stefans_spotify']],
            'bonnieb'   => [['Twitter','@bonnieb'],['Instagram','@bonnieb']],
            'carolinef' => [['Instagram','@carolinef']],
        ];

        foreach ($members as $m) {
            $user = User::create([
                'name'              => $m['name'],
                'username'          => $m['username'],
                'email'             => $m['username'] . '@wetaract.com',
                'password'          => Hash::make('password'),
                'avatar'            => 'https://picsum.photos/seed/' . $m['seed'] . '/200',
                'membership_status' => $m['status'],
                'is_elite_verified' => $m['elite'],
                'points'            => $m['points'],
                'wallet_balance'    => rand(10, 200),
                'interests'         => $m['interests'],
                'referral_code'     => strtoupper(substr($m['username'], 0, 6) . rand(10, 99)),
                'visibility_score'  => rand(40, 95),
                'engagement_rate'   => rand(5, 20),
            ]);

            foreach ($memberHandles[$m['username']] ?? [] as [$platform, $handle]) {
                SocialHandle::create(['user_id' => $user->id, 'platform' => $platform, 'handle' => $handle]);
            }
        }

        $alexUser = User::where('username', 'elenag')->first();
        $brandUser = User::where('username', 'damons')->first();

        Campaign::create(['user_id' => $alexUser->id, 'platform' => 'Instagram', 'action_type' => 'Like',   'link' => 'https://instagram.com/p/123',             'description' => 'Check out my latest travel photography from Bali! Would appreciate the love.', 'total_slots' => 100, 'remaining_slots' => 45,  'reward_type' => 'Points', 'reward_value' => 50,   'campaign_type' => 'Reciprocity', 'creator_interests' => ['Travel','Photography','Lifestyle']]);
        Campaign::create(['user_id' => $brandUser->id, 'platform' => 'YouTube',  'action_type' => 'View',   'link' => 'https://youtube.com/watch?v=paid-video',   'description' => 'Watch our new product launch video for at least 3 minutes to earn real cash reward!', 'total_slots' => 500, 'remaining_slots' => 240, 'reward_type' => 'Cash',   'reward_value' => 2.50, 'campaign_type' => 'Paid',        'use_ai' => true, 'creator_interests' => ['Tech','Business','Marketing']]);
        Campaign::create(['user_id' => $alexUser->id, 'platform' => 'YouTube',  'action_type' => 'Play',   'link' => 'https://youtube.com/watch?v=456',           'description' => 'New track just dropped! Please play and stream for at least 60 seconds.', 'total_slots' => 500, 'remaining_slots' => 10,  'reward_type' => 'Points', 'reward_value' => 150,  'campaign_type' => 'Reciprocity', 'creator_interests' => ['Music','Nightlife','Tech']]);
        Campaign::create(['user_id' => $brandUser->id, 'platform' => 'Twitter',  'action_type' => 'Repost', 'link' => 'https://twitter.com/gamehub/status/123',   'description' => 'Repost our latest giveaway post to win a PS5 and earn instant cash.', 'total_slots' => 100, 'remaining_slots' => 15,  'reward_type' => 'Cash',   'reward_value' => 1.00, 'campaign_type' => 'Paid',        'target_location' => 'USA', 'creator_interests' => ['Gaming','Tech','Entertainment']]);
    }
}
