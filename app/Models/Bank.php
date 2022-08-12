<?php

namespace App\Models;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Bank extends Model
{
    use HasFactory,LogsActivity,DefaultDatetimeFormat;

    protected static $logAttributes = ['name','country_id'];
    
    protected $fillable = ['name','country_id'];

    /* public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    } */

    public function bank()
    {
        return $this->hasMany(BankAccount::class, 'bank_id', 'id');
    }

    public function from_bank()
    {
        return $this->hasMany(Transaction::class, 'from_bank', 'id');
    }

    public function your_receive_bank()
    {
        return $this->hasMany(Transaction::class, 'your_receive_bank', 'id');
    }

    /* public function to_bank()
    {
        return $this->hasMany(Transaction::class, 'to_bank_id', 'id');
    } */

    /* protected $casts = [
        'created_at'  => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
    ]; */

    protected $casts = [
        'country_id' =>'json',
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
