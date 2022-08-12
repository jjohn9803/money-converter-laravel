<?php

namespace App\Admin\Actions\Transactions;

use App\Models\Notification;
use App\Models\Reason;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Reject extends RowAction
{
    function name()
    {
        return __('admin.custom.transactions.reject');
    }

    protected function getLocale()
    {
        $locale = App::getLocale();
        if (str_contains($locale, 'zh')) $locale = 'zh';
        return $locale;
    }

    public function handle(Model $model, Request $request)
    {
        if ($model->status == 2) {
            $reason = $request->get('reason') ?? -1;
            $model->status = 5;
            $message = 5;

            $notification = Notification::create([
                'user_id' => $model->user_id,
                'transasction_id' => $model->id,
                'message_type' => $message,
                'reason_id' => $reason,
                'status' => 1,
            ]);

            $model->save();
            return $this->response()->success('Success message.')->refresh();
        } else {
            return $this->response()->error('You cannot update while not confirmed stataus.')->refresh();
        }
    }

    public function form()
    {
        //$this->textarea('reason', 'Reason')->help('You may empty reason if you are accepting...');
        $this->select('reason', __('admin.custom.transactions.reason'))->options(function () {
            $array = Reason::all();
            $result_array = [];
            foreach ($array as $key => $value) {
                try {
                    $result_array[$value->id] = $value->message[self::getLocale()];
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
            return $result_array;
        })->default(-1);
    }

    public function display($star)
    {
        return $star ? null : "<span class='btn btn-sm btn-danger'><i class='fa fa-ban'></i></span>";
    }
}
