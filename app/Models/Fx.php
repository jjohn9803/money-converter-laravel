<?php

namespace App\Models;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Fx extends Model
{
    use HasFactory,LogsActivity,DefaultDatetimeFormat;

    protected static $logAttributes = ['result_currency_id','fx_rate'];
    
    protected $fillable = ['result_currency_id','fx_rate'];

    /* public function base_currency()
    {
        return $this->belongsTo(Currency::class, 'base_currency_id');
    } */

    public function result_currency()
    {
        return $this->belongsTo(Currency::class, 'result_currency_id');
    }

    /* public function fx()
    {
        return $this->hasMany(Fx::class, 'fx_id', 'id');
    } */

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
