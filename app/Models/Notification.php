<?php

namespace App\Models;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Notification extends Model
{
    use HasFactory, LogsActivity, DefaultDatetimeFormat;

    protected static $logAttributes = ['user_id', 'transasction_id', 'message_type', 'reason_id', 'status'];

    protected $fillable = ['user_id', 'transasction_id', 'message_type', 'reason_id', 'status'];

    public function transasction()
    {
        return $this->belongsTo(Transaction::class, 'transasction_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reason()
    {
        return $this->belongsTo(Reason::class, 'reason_id');
    }

    /* public function fx()
    {
        return $this->hasMany(Fx::class, 'fx_id', 'id');
    } */

    protected $casts = [
        /* 'created_at'  => 'json' */
        /* 'created_at'  => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s', */];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty()
            ->logFillable();
        // Chain fluent methods for configuration options
    }
}
