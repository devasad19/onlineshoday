<?php
// app/Models/Rider.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'age',
        'edu_qualification',
        'institute',
        'vehicle_type',
        'nid_image',
        'available',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }


}
