<?php

namespace App\Http\Requests\application;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Rules\MaxWordsRule;

class ApplicationReuest extends FormRequest
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
        return [
            // 'guardian_id'            => 'required|numeric',
            'student_name'              => ['bail', 'required', 'string', new MaxWordsRule()],
            'birth_place'               => 'bail|required|string',
            'national_id'               => 'bail|required|numeric|unique:applications',
            'birth_date'                => 'bail|required|date',
            'student_care'              => 'bail|required|boolean',
            'nationality_id'            => 'bail|required|numeric',
            'plan_id'                   => 'bail|required|numeric',
            // 'school_id'                   => 'bail|required',
            'academic_year_id'          => 'bail|required',
            'level_id'                  => 'bail|required',
            'online'                    => 'bail|required|boolean',
            'transportation_required'   => 'bail|required|boolean',
            'transportation_id'         => 'bail|' . Rule::requiredIf(function () use ($request) {
                return $request->transportation_required;
            }),
            'transportation_payment'    => 'bail|' . Rule::requiredIf(function () use ($request) {
                return $request->transportation_required;
            }),
            'selected_date'             => 'bail|required|date|after_or_equal:' . Carbon::now()->addDay()->toDateString(),
            'selected_time'             => 'bail|required|date_format:H:i',

        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'student_name' => 'اسم الطالب'
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

            'online.required' => 'رجاء اختيار مكان المقابلة',
            'online.boolean' => 'مكان المقابلة غير صحيح',

            'selected_date.required' => 'رجاء تحديد التاريخ اولا',
            'selected_date.date' => 'صيغة التاريخ غير صحيحة',
            'selected_date.after_or_equal' => 'لا يمكن اختيار تاريخ قبل : ' . Carbon::now()->addDay()->format('d-m-Y'),

            'selected_time.required' => 'رجاء تحديد ميعاد المقابلة اولا',
            'selected_time.date_format' => 'صيغة موعد المقابلة غير صحيحة',
            'selected_time.before_or_equal' => 'لا يمكن اختيار ميعاد بعد الساعة : ' . Carbon::parse(env('MEETING_TO'))->format('h:i:s A'),
            'selected_time.after_or_equal' => 'لا يمكن اختيار ميعاد قبل الساعة : ' . Carbon::parse(env('MEETING_FROM'))->format('h:i:s A'),

            'academic_year_id.required' => 'رجاء تحديد العام الدراسي الذي سيتم التقديم الية'
        ];
    }

    protected function prepareForValidation()
    {

        $transportation_payment = $this->transportation_payment;

        switch ($transportation_payment) {
            case 'annual_fees':
                $transportation_payment = 1;
                break;
            case 'semester_fees':
                $transportation_payment = 2;
                break;
            case 'monthly_fees':
                $transportation_payment = 3;
                break;
            case 'undefined' || null:
                $transportation_payment = null;
                break;
            default:
                break;
        }

        $this->merge([
            'transportation_payment' =>  $transportation_payment,
        ]);
    }
}
