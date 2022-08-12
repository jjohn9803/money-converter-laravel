<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TimeoutJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $transaction;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $transaction = Transaction::find($this->transaction->id);
        if ($transaction->status == '1') {
            $uid = $transaction->user_id;
            $transaction->update(['status' => '5']);
            $notification = Notification::create([
                'user_id' => $uid,
                'transasction_id' => $this->transaction->id,
                'message_type' => 6,
                'reason_id' => -1,
                'status' => 1,
            ]);
        }
    }
}
