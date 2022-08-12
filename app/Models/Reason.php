<?php

namespace App\Models;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Reason extends Model
{
    use HasFactory,LogsActivity,DefaultDatetimeFormat;

    protected static $logAttributes = ['message'];
    
    protected $fillable = ['message'];

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'reason_id', 'id');
    }

    /* public function fx()
    {
        return $this->hasMany(Fx::class, 'fx_id', 'id');
    } */

    protected $casts = [
        'message' =>'json',
        /* 'created_at'  => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s', */
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty()
            ->logFillable();
        // Chain fluent methods for configuration options
    }
}
