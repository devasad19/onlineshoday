<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Advertisement extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'category',
        'ad_type',
        'provider_name',
        'provider_type',
        'short_description',
        'description',
        'image',
        'location',
        'phone',
        'price_label',
        'status',
        'rejection_reason',
        'is_featured',
        'approved_by',
        'approved_at',
        'expires_at',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'approved_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'approved')
            ->where(function ($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            });
    }
}
