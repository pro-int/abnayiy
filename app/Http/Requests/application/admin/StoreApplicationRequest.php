<?php

namespace App\Http\Requests\application\admin;

use App\Http\Requests\GeneralRequest;
use App\Rules\MaxWordsRule;
use Illuminate\Validation\Rule;

class StoreApplicationRequest extends GeneralRequest
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
//            'guardian_id'       => 'required|numeric',
            'student_name'      => ['bail', 'required', 'string', new MaxWordsRule()],
            'birth_place'       => 'required|string|min:3|max:20',
            'national_id'       => 'required|numeric|' . Rule::unique('applications')->where('academic_year_id', $this->academic_year_id),
            'birth_date'        => 'required|date',
            'student_care'      => 'required',
            'nationality_id'    => 'required|numeric',
            'plan_id'           => 'required|numeric',
            'school_id'           => 'required',
            'level_id'          => 'required',
            'grade_id'          => 'required',
            'selected_date'     => 'required',
            'selected_time'     => 'required',
            'transportation_id' => 'required_unless:transportation_payment,null',
            'transportation_payment' => 'required_unless:transportation_id,null'

        ];
    }

    public function attributes()
    {
        return [
            'student_name' => 'اسم الطالب',
            'transportation_id' => 'خطة النقل',
            'transportation_payment' => 'خطة دفع النقل',
            'date'              => 'تاريخ المقابلة',
            'appointment_time'  => 'موعد المقابلة',
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
            'guardian_id.required'        => 'رجاء التأكد من تسجيل الدخول والا',
            'guardian_id.numeric'         => 'رجاء التأكد من تسجيل الدخول والا',

            'student_name.required'       => 'يجب ادخال الاسم الاول بشكل صحيح !!',
            'student_name.string'         => 'الاسم الاول يجب ان يكون حروف فقط !!',
            'student_name.max'            => 'الاسم الاول لا يمكن ان يكون اكبر من 20 حرف !! ',
            'student_name.min'            => 'الاسم الاول لا يمكن ان يكون اقل من 3 احرف !! ',

            'birth_place.required'       => 'يجب ادخال مكان الميلاد بشكل صحيح !!',
            'birth_place.string'         => 'مكان الميلاد يجب ان يكون حروف فقط !!',
            'birth_place.max'            => 'مكان الميلاد لا يمكن ان يكون اكبر من 20 حرف !! ',
            'birth_place.min'            => 'مكان الميلاد لا يمكن ان يكون اقل من 3 احرف !! ',

            'national_id.required'       => 'رقم هوية الطالب',
            'national_id.unique'         => 'رقم هوية الطالب مسجل لدينا مسبقا',
            'national_id.numeric'        => 'رقم هوية الطالب يجب ان يكون ارقام فقط',

            'birth_date.required'       => 'تايخ الميلاد مطلوب',
            'birth_date.date'           => 'رجاء ادخال التاريخ بشكل صحيح',

            'student_care.required'        => 'رجاء تحديد طبيعة الرعاية',
            'student_care.boolean'         => 'رجاء تحديد ما اذا كان الطالب يحتاج رعاية خاصة',

            'nationality_id.required'       => 'رجاء اختيار جنسية الطالب',
            'nationality_id.numeric'        => 'رجاء تحديد جنسية الطالب من القائمة',

            'school_id.required'         => 'رجاء اختيار النظام التعليمي',

            'level_id.required'         => 'رجاء اختيار المرحلة',

            'grade_id.required'         => 'رجاء اختيار الصف',

            'plan_id.required'         => 'رجاء اختيار الصف',

        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'student_care' => (bool) $this->student_care,
            'online' => (bool) $this->online,
            'transportation_required' => !is_null($this->transportation_id) && ! is_null($this->transportation_payment)
        ]);
    }
}
