<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'user_id',
        'update_time',
    ];

    protected $casts = [
        'update_time' => 'datetime',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
