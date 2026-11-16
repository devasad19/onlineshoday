<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AdvertisementCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function advertisements()
    {
        return $this->hasMany(
            Advertisement::class,
            'category',
            'name'
        );
    }

    public function getAdsCountAttribute()
    {
        return Advertisement::where('category', $this->name)->count();
    }
}
