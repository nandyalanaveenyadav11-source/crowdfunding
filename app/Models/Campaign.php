<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'goal_amount',
        'current_amount',
        'deadline',
        'image',
        'status',
        'category',
        'type',
        'reward_details',
        'equity_details',
        'repayment_details',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function updates()
    {
        return $this->hasMany(CampaignUpdate::class);
    }

    public function getProgressPercentageAttribute()
    {
        if ($this->goal_amount <= 0) return 0;
        return min(100, round(($this->current_amount / $this->goal_amount) * 100));
    }}
