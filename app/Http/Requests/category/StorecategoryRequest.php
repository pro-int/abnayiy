<?php

namespace App\Http\Requests\category;

use App\Http\Requests\GeneralRequest;
use Illuminate\Validation\Rule;

class StorecategoryRequest extends GeneralRequest
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
        info($this);
        return [
            'category_name' => 'required|string|min:3|max:50|' . Rule::unique('categories'),
            'promotion_name' => 'required|string|min:3|max:50|' . Rule::unique('categories'),
            'description' => 'required|string|min:3|max:200',
            'is_default' => Rule::unique('categories')->where('is_default',1),
            'required_points' => 'required|'. Rule::unique('categories')
            
        ];
    }

    public function attributes()
    {
        return [
            'category_name' => 'اسم الفئة',

            'promotion_name' => 'االأسم الترويجي',

            'description' => 'الوصف',

            'required_points' => 'الحد الأدني للنقاط'
        ];
    }

    public function messages()
    {
        return [
            'is_default.unique' => 'لا يمكن اختيار اكتر من فئة كفئة افتراضية',
            'required_points.unique' => 'توجد فئة اخري تتطلب نفس عدد النقاط',
        ];
    }

    protected function prepareForValidation()
    {
        isset($this->is_default) &&  $this->merge([
            'is_default' => (bool) $this->is_default,
        ]);

        $this->merge([
            'active' => (bool) $this->active, 'is_fixed' => (bool) $this->is_fixed]);
    }
}
