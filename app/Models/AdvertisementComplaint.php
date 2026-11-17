<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdvertisementComplaint extends Model
{
    protected $fillable = [
        'complaint_code',
        'user_id',
        'advertisement_id',
        'complaint_type',
        'description',
        'evidence',
        'desired_resolution',
        'status',
        'admin_response',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function advertisement(): BelongsTo
    {
        return $this->belongsTo(Advertisement::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'received' => 'অভিযোগ গ্রহণ করা হয়েছে',
            'under_review' => 'পর্যালোচনাধীন',
            'need_information' => 'অতিরিক্ত তথ্য প্রয়োজন',
            'resolved' => 'সমাধান হয়েছে',
            'rejected' => 'অভিযোগ গ্রহণযোগ্য নয়',
            'closed' => 'বন্ধ করা হয়েছে',
            default => 'অজানা',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'received' => 'blue',
            'under_review' => 'warning',
            'need_information' => 'purple',
            'resolved' => 'success',
            'rejected' => 'danger',
            'closed' => 'secondary',
            default => 'secondary',
        };
    }
}
