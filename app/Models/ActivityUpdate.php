<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityUpdate extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_DONE = 'done';
    const STATUS_DELETED = 'deleted';

    protected $fillable = [
        'activity_id',
        'user_id',
        'status',
        'remark',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public static function getValidStatuses()
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_DONE,
            self::STATUS_DELETED
        ];
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
