<?php

namespace App\Models;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class HomePage extends Model
{
    use HasFactory, LogsActivity, DefaultDatetimeFormat;

    protected static $logAttributes = ['name', 'value'];

    protected $fillable = ['name', 'value'];

    /* public function base_currency()
    {
        return $this->belongsTo(Currency::class, 'base_currency_id');
    } */

    /* public function result_currency()
    {
        return $this->belongsTo(Currency::class, 'result_currency_id');
    } */

    /* public function fx()
    {
        return $this->hasMany(Fx::class, 'fx_id', 'id');
    } */

    protected $casts = [
        'value' => 'json',
    ];

    /* protected $casts = [
        'created_at'  => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
    ]; */

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty()
            ->logFillable();
        // Chain fluent methods for configuration options
    }
}
