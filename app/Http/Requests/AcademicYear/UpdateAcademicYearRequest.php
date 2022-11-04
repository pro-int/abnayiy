<?php

namespace App\Http\Requests\AcademicYear;

use App\Http\Requests\GeneralRequest;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class UpdateAcademicYearRequest extends GeneralRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'year_name' => 'required|' . Rule::unique('academic_years')->ignore($this->year->id),
            'year_numeric' => 'required|numeric|' . Rule::unique('academic_years')->ignore($this->year->id),
            'year_hijri' => 'required|numeric|' . Rule::unique('academic_years')->ignore($this->year->id),
            'year_start_date' => 'required|date|before:year_end_date',
            'year_end_date' => 'required|date|after:year_start_date',
            'fiscal_year_end' => 'required|date|after:year_start_date',
            'start_transition' => 'required|date|after:year_start_date|before:year_end_date',
            'is_open_for_admission' => Rule::unique('academic_years')->where('is_open_for_admission',1)->ignore($this->year->id),
            'current_academic_year' => Rule::unique('academic_years')->where('current_academic_year',1)->ignore($this->year->id),
            // 'next_year_id' => Rule::unique('academic_years')->ignore($this->next_year_id),
            'min_tuition_percent' => 'required|digits_between:0,100',
            'min_debt_percent' => 'required|digits_between:0,100',

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
            'year_name.required' => 'اسم العام الدراسي مطلوب',
            'year_name.unique' => 'اسم العام الدراسي ميدل مسبقا',

            'year_numeric.required' => 'السنة الميلادية للعام الدراسي مطلوبة',
            'year_numeric.numeric' => 'السنة الميلادية للعام الدراسي يجب ان تكون ارقام فقط',
            'year_numeric.unique' => 'العام الميلادي مسجل مسبقا',

            'year_hijri.required' => 'السنة الهجري للعام الدراسي مطلوبة',
            'year_hijri.numeric' => 'السنة الهجري للعام الدراسي يجب ان تكون ارقام فقط',
            'year_hijri.unique' => 'العام الهجري مسجل مسبقا',

            'year_start_date.required' => 'تاريخ بداية العام الدراسي مطلوب ',
            'year_start_date.date' => 'صيغة تاريخ  بداية العام الدراسي  غير صحيحة ',
            'year_start_date.before' => 'تاريخ بداية العام الدراسي يجب ان يكون قبل تاريخ نهاية العام ',

            'year_end_date.required' => 'تاريخ نهاية العام الدراسي مطلوب',
            'year_end_date.date' => 'صيغة تاريخ  نهاية العام الدراسي  غير صحيحة',
            'year_end_date.before' => 'تاريخ نهاية العام الدراسي يجب ان يكون بعد تاريخ بداية العام',

            'start_transition.required' => 'تاريخ بداية ترحيل الطلاب مطلوب',
            'start_transition.date' => 'صيغة تاريخ بداية ترحيل الطلاب غير صحيحة',
            'start_transition.after' => 'تاريخ  ترحيل الطلاب يجب ان يكون بعد تاريخ بداية العام',
            'start_transition.before' => 'تاريخ  ترحيل الطلاب يجب ان يكون قبل تاريخ نهاية العام',

            'fiscal_year_end.required' => 'تاريخ نهاية السنة المالية مطلوب',
            'fiscal_year_end.date' => 'صيغة تاريخ نهاية السنة المالية غير صحيحة',
            'fiscal_year_end.after' => 'تاريخ السنة المالية يجب ان يكون بعد تاريخ بداية العام',

            'is_open_for_admission.unique' => 'لا يمكن تحديد اكثر من عام دراسي متاح للتقديم في نقس الوقت',
            'current_academic_year.unique' => 'لا يمكن تحديد اكثر من عام دراسي ليصبح العام الدراسي الحالي'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_open_for_admission' => (bool) $this->is_open_for_admission,
            'current_academic_year' => (bool) $this->current_academic_year,
            'last_installment_date' => Carbon::parse($this->last_installment_date . '-27')
        ]);
    }
}
