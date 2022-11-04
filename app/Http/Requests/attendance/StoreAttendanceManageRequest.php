<?php

namespace App\Http\Requests\attendance;

use App\Http\Requests\GeneralRequest;

class StoreAttendanceManageRequest extends GeneralRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'admin_id'    => 'required|exists:admins,admin_id',
            'level_id'     => 'required|array',
        ];
    }

    public function messages()
    {
        return
            [
                'admin_id.required'    => 'رجاء تحديد المشرف',
                'admin_id.numeric'    => 'رجاء تحديد المشرف',
                'admin_id.exists'    => 'المستخدم الذي تم اختيارة غير مسجل كمدير للنظام',
                'level_id'     => 'رجاء تحديد مرحلة واحدة علي الاقل'
            ];
    }
}
