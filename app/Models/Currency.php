<?php

namespace App\Models;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Currency extends Model
{
    use HasFactory,LogsActivity,DefaultDatetimeFormat;

    protected static $logAttributes = ['name','country_id'];
    
    protected $fillable = ['name','country_id'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    /* public function base_currency()
    {
        return $this->hasMany(Fx::class, 'base_currency_id', 'id');
    } */

    public function result_currency()
    {
        return $this->hasMany(Fx::class, 'result_currency_id', 'id');
    }

    public function from_curr()
    {
        return $this->hasMany(Transaction::class, 'from_curr_id', 'id');
    }

    public function to_curr()
    {
        return $this->hasMany(Transaction::class, 'to_curr_id', 'id');
    }

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
