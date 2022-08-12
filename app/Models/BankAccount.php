<?php

namespace App\Models;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BankAccount extends Model
{
    use HasFactory,LogsActivity,DefaultDatetimeFormat;

    protected static $logAttributes = ['account_no','bank_id','status'];
    
    protected $fillable = ['account_no','bank_id','status'];

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'to_acc_id', 'id');
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
