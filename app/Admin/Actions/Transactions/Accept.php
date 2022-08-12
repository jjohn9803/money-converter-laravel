<?php

namespace App\Admin\Actions\Transactions;

use App\Models\Notification;
use App\Models\Reason;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Accept extends RowAction
{
    function name()
    {
        return __('admin.custom.transactions.accept');
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
            $model->status = 4;
            $message = 4;

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
        $this->select('reason', __('admin.custom.transactions.message'))->options(function () {
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
        $this->file('recipient_receipt_img_path', __('admin.choose_file'));
    }

    public function display($star)
    {
        return $star ? null : "<span class='btn btn-sm btn-success'><i class='fa fa-check'></i></span>";
    }
}
