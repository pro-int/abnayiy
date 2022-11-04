<?php

namespace App\Http\Requests\Contract\Files;

use App\Http\Requests\GeneralRequest;

class StoreContractFileRequest extends GeneralRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'file_type' => 'required',
            'file_path' => 'required|mimes:jpg,jpeg,bmp,png,pdf'
        ];
    }

    public function attributes()
    {
        return [
            'file_type' => 'نوع المرفق',
            'file_path' => 'الملف المرفق'
        ];
    }
}
