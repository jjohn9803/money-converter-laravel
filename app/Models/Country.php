<?php

namespace App\Models;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Country extends Model
{
    use HasFactory, LogsActivity, DefaultDatetimeFormat;

    protected static $logAttributes = ['name', 'alpha_2_code', 'min_amt', 'max_amt'];

    protected $fillable = ['name', 'alpha_2_code', 'min_amt', 'max_amt'];

    public function bank()
    {
        return $this->hasMany(Bank::class, 'country_id', 'id');
    }

    public function currency()
    {
        return $this->hasMany(Bank::class, 'country_id', 'id');
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
