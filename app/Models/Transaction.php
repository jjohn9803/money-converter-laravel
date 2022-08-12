<?php

namespace App\Models;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Transaction extends Model
{
    use HasFactory, LogsActivity, DefaultDatetimeFormat;

    protected static $logAttributes = ['user_id', 'from_acc', 'from_bank', 'your_receive_acc', 'your_receive_bank', 'to_acc_id', 'from_curr_id', 'to_curr_id', 'fx_rate', 'from_amount', 'to_amount', 'ref_no', 'receipt_img_path', 'recipient_receipt_img_path', 'status'];

    protected $fillable = ['user_id', 'from_acc', 'from_bank', 'your_receive_acc', 'your_receive_bank', 'to_acc_id', 'from_curr_id', 'to_curr_id', 'fx_rate', 'from_amount', 'to_amount', 'ref_no', 'receipt_img_path', 'recipient_receipt_img_path', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /* public function to_acc()
    {
        return $this->belongsTo(BankAccount::class, 'to_acc_id');
    }

    public function from_bank1()
    {
        return $this->belongsTo(Bank::class, 'from_bank');
    }

    public function your_receive_bank1()
    {
        return $this->belongsTo(Bank::class, 'your_receive_bank');
    } */

    /* public function to_bank()
    {
        return $this->belongsTo(Bank::class, 'to_bank_id');
    } */

    /* public function from_curr()
    {
        return $this->belongsTo(Currency::class, 'from_curr_id');
    }

    public function to_curr()
    {
        return $this->belongsTo(Currency::class, 'to_curr_id');
    } */

    /* public function fx()
    {
        return $this->belongsTo(Fx::class, 'fx_id');
    } */

    public function transasction()
    {
        return $this->hasMany(Notification::class, 'transasction_id', 'id');
    }

    protected $casts = [
        'to_acc_id' => 'json',
        'from_bank' => 'json',
        'your_receive_bank' => 'json',
        'from_curr_id' => 'json',
        'to_curr_id' => 'json',
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
