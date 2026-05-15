<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowsPact extends Model
{
    use HasFactory;

    protected $table = 'follows_pact';

    protected $fillable = ['follower_id', 'following_id', 'platform', 'is_reciprocal'];

    protected function casts(): array
    {
        return ['is_reciprocal' => 'boolean'];
    }

    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    public function following()
    {
        return $this->belongsTo(User::class, 'following_id');
    }
}
