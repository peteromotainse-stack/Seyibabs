<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'platform', 'action_type', 'link', 'description',
        'total_slots', 'remaining_slots', 'reward_value', 'reward_type',
        'campaign_type', 'use_ai', 'target_location', 'budget',
        'platform_fee', 'creator_interests',
    ];

    protected function casts(): array
    {
        return [
            'use_ai' => 'boolean',
            'reward_value' => 'decimal:2',
            'budget' => 'decimal:2',
            'platform_fee' => 'decimal:2',
            'creator_interests' => 'array',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function completions()
    {
        return $this->hasMany(CampaignCompletion::class);
    }

    public function getProgressAttribute(): float
    {
        if ($this->total_slots === 0) return 0;
        return (1 - ($this->remaining_slots / $this->total_slots)) * 100;
    }
}
