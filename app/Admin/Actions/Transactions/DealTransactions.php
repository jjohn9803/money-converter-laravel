<?php

namespace App\Admin\Actions\Transactions;

use App\Models\Notification;
use App\Models\Reason;
use Encore\Admin\Actions\RowAction;
use Encore\Admin\Admin;
use ErrorException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class DealTransactions extends RowAction
{
    //public $name = 'Action';

    function name()
    {
        return __('admin.custom.transactions.action');
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
            $type = $request->get('type') ?? -1;
            $reason = $request->get('reason') ?? -1;
            if ($type == 1) {
                $model->status = 4;
                $message = 4;
            } else if ($type == 2) {
                $model->status = 5;
                $message = 5;
            } else {
                return $this->response()->error('Something went wrong!')->refresh();
            }

            $file = $request->file('recipient_receipt_img_path');
            if ($file) {
                $path = 'recipientReceiptAttach/';
                $folder = '';
                //$folder = $request->id . '/';
                $file_name = time() . '_' . $file->getClientOriginalName();
                //$tbl_users->profile_pic_path = $file_name;
                $model->recipient_receipt_img_path = $folder . $file_name;
                $upload = $file->move(public_path('recipientReceiptAttach'), $file_name);
                //$upload = $file->storeAs($path . $folder, $file_name, 'local');
            }

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
        $type = [
            1 => __('admin.custom.transactions.accept'),
            2 => __('admin.custom.transactions.reject'),
        ];

        $this->radio('type', __('admin.custom.transactions.type'))->options($type)->required();
        //$this->textarea('reason', 'Reason')->help('You may empty reason if you are accepting...');
        $this->select('reason', __('admin.custom.transactions.reason'))->options(function () {
            $array = Reason::all();
            $result_array = [];
            foreach ($array as $key => $value) {
                $result_array[$key] = $value->message[self::getLocale()];
            }
            return $result_array;
        })->default(-1);
        $this->file('recipient_receipt_img_path', __('admin.choose_file'));
    }

    public function display($star)
    {
        return $star ? null : "<span class='btn'><i class='fa fa-paper-plane'></i></span>";
    }
}
