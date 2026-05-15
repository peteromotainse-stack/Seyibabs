<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'username', 'email', 'password', 'phone', 'avatar',
        'membership_status', 'is_elite_verified', 'points', 'wallet_balance',
        'total_withdrawn', 'following_count', 'followers_count', 'interests',
        'referral_code', 'referred_by', 'total_referrals', 'referral_earnings',
        'referral_pending', 'warnings', 'visibility_score', 'engagement_rate',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'interests' => 'array',
            'is_elite_verified' => 'boolean',
            'wallet_balance' => 'decimal:2',
            'total_withdrawn' => 'decimal:2',
            'referral_earnings' => 'decimal:2',
            'referral_pending' => 'decimal:2',
            'engagement_rate' => 'decimal:2',
        ];
    }

    public function socialHandles()
    {
        return $this->hasMany(SocialHandle::class);
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->latest();
    }

    public function campaignCompletions()
    {
        return $this->hasMany(CampaignCompletion::class);
    }

    public function getHandlesMapAttribute(): array
    {
        return $this->socialHandles->pluck('handle', 'platform')->toArray();
    }

    public function getReferralConversionRateAttribute(): string
    {
        if ($this->total_referrals === 0) return '0%';
        return round(($this->referral_earnings / max($this->total_referrals, 1)) * 10) . '%';
    }
}
