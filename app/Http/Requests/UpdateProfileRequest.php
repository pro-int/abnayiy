<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
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
    public function rules(Request $request)
    {
        \Log::info($request);
        return [
            'first_name'        => 'required|min:3|max:20',
            'last_name'         => 'required|min:3|max:20',
            'email'             => 'required|email|max:50|' . Rule::unique('users')->ignore(Auth::id()),
            'phone'             => 'required|numeric|' . Rule::unique('users')->ignore(Auth::id()),
            'country_id'        => 'required',
            // 'password'          => 'required|confirmed|min:8',

            'nationality_id'    => 'required',
            'city_name'         => 'required',
            'address'           => 'required|string|max:191',
            'national_id'       => 'required|numeric',

        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.required'       => 'يجب ادخال الاسم الاول بشكل صحيح !!',
            'first_name.string'         => 'الاسم الاول يجب ان يكون حروف فقط !!',
            'first_name.max'            => 'الاسم الاول لا يمكن ان يكون اكبر من 20 حرف !! ',
            'first_name.min'            => 'الاسم الاول لا يمكن ان يكون اقل من 3 احرف !! ',


            'last_name.required'       => 'يجب ادخال الاسم الاخير بشكل صحيح !!',
            'last_name.string'         => 'الاسم الاخير يجب ان يكون حروف فقط !!',
            'last_name.max'            => 'الاسم الاخير لا يمكن ان يكون اكبر من 20 حرف !! ',
            'last_name.min'            => 'الاسم الاخير لا يمكن ان يكون اقل من 3 احرف !! ',

            'email.required'         => 'البريد الألكتروني مطلوب',
            'email.email'         => 'ادخل البريد الألكتروني بشكل صحيح',
            'email.unique'         => 'البريد الأليكتروني مسجل لدينا بالفعل',
            'email.max'         => 'البريد الأليكتروني يجب ان يكون اقل من 50 حرف',


            'country_id.required'         => 'رجاء اختيار الدولة',

            'phone.required'         => 'رقم الجوال مطلوب',
            'phone.digits'         => 'رقم الجوال يجب ان يكون 11 رقم',
            'phone.unique'         => 'رقم الجوال مسجل لدينا بالفعل',

            'phone.required'         => 'رقم الجوال مطلوب',
            'phone.digits'         => 'رقم الجوال يجب ان يكون 11 رقم',
            'phone.unique'         => 'رقم الجوال مسجل لدينا بالفعل',

        ];
    }
}
