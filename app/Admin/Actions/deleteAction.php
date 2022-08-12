<?php

namespace App\Admin\Actions;

use App\Models\Notification;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class deleteAction extends RowAction
{

    public function handle(Model $model)
    {
        if ($model->delete()) {
            return $this->response()->success(__('admin.delete_succeeded'))->refresh();
        } else {
            return $this->response()->error(__('admin.delete_failed'))->refresh();
        }
    }

    public function dialog()
    {
        $this->confirm(__('admin.delete_confirm'));
    }

    public function display($star)
    {
        return $star ? null : "<span class='btn btn-sm btn-danger'>" . __('admin.delete') . "</span>";
    }
}
