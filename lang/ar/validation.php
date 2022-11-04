<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'حقل :attribute must be accepted.',
    'accepted_if' => 'حقل :attribute must be accepted when :other is :value.',
    'active_url' => 'حقل :attribute is not a valid URL.',
    'after' => 'حقل :attribute يجب ان يكون بعد :date.',
    'after_or_equal' => 'حقل :attribute يجب ان يكون بعد او مساوي لـ :date.',
    'alpha' => 'حقل :attribute must only contain letters.',
    'alpha_dash' => 'حقل :attribute must only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'حقل :attribute must only contain letters and numbers.',
    'array' => 'حقل :attribute must be an array.',
    'before' => 'حقل :attribute يجب ان يكون قبل :date.',
    'before_or_equal' => 'حقل :attribute يجب ان يكون قبل او مساوي لـ :date.',
    'between' => [
        'numeric' => 'حقل :attribute must be between :min and :max.',
        'file' => 'حقل :attribute must be between :min and :max kilobytes.',
        'string' => 'حقل :attribute must be between :min and :max حروف.',
        'array' => 'حقل :attribute must have between :min and :max items.',
    ],
    'boolean' => 'حقل :attribute field must be true or false.',
    'confirmed' => 'حقل :attribute مغير متطابق.',
    'current_password' => 'حقل password is incorrect.',
    'date' => 'حقل :attribute is not a valid date.',
    'date_equals' => 'حقل :attribute must be a date equal to :date.',
    'date_format' => 'حقل :attribute does not match the format :format.',
    'declined' => 'حقل :attribute must be declined.',
    'declined_if' => 'حقل :attribute must be declined when :other is :value.',
    'different' => 'حقل :attribute and :other must be different.',
    'digits' => 'حقل :attribute must be :digits digits.',
    'digits_between' => 'حقل :attribute must be between :min and :max digits.',
    'dimensions' => 'حقل :attribute has invalid image dimensions.',
    'distinct' => 'حقل :attribute field has a duplicate value.',
    'email' => 'حقل :attribute must be a valid email address.',
    'ends_with' => 'حقل :attribute must end with one of the following: :values.',
    'exists' => 'حقل selected :attribute غير صحيح.',
    'file' => 'حقل :attribute must be a file.',
    'filled' => 'حقل :attribute field must have a value.',
    'gt' => [
        'numeric' => 'حقل :attribute must be greater than :value.',
        'file' => 'حقل :attribute must be greater than :value kilobytes.',
        'string' => 'حقل :attribute must be greater than :value حروف.',
        'array' => 'حقل :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'حقل :attribute must be greater than or equal to :value.',
        'file' => 'حقل :attribute must be greater than or equal to :value kilobytes.',
        'string' => 'حقل :attribute must be greater than or equal to :value حروف.',
        'array' => 'حقل :attribute must have :value items or more.',
    ],
    'image' => 'حقل :attribute must be an image.',
    'in' => 'حقل selected :attribute غير صحيح.',
    'in_array' => 'حقل :attribute field does not exist in :other.',
    'integer' => 'حقل :attribute must be an integer.',
    'ip' => 'حقل :attribute must be a valid IP address.',
    'ipv4' => 'حقل :attribute must be a valid IPv4 address.',
    'ipv6' => 'حقل :attribute must be a valid IPv6 address.',
    'json' => 'حقل :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'حقل :attribute must be less than :value.',
        'file' => 'حقل :attribute must be less than :value kilobytes.',
        'string' => 'حقل :attribute must be less than :value حروف.',
        'array' => 'حقل :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'حقل :attribute يجب ان يكون اقل من او يساوي :value.',
        'file' => 'حقل :attribute يجب ان يكون اقل من او يساوي :value kilobytes.',
        'string' => 'حقل :attribute يجب ان يكون اقل من او يساوي :value حروف.',
        'array' => 'حقل :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => 'حقل :attribute يجب ان يكون اكبر من :max.',
        'file' => 'حقل :attribute يجب ان يكون اكبر من او يساوي  :max kilobytes.',
        'string' => 'حقل :attribute يجب ان يكون اكبر من او يساوي  :max حروف.',
        'array' => 'حقل :attribute must not have more than :max items.',
    ],
    'mimes' => 'حقل :attribute يجب ان يكون من النوع :values.',
    'mimetypes' => 'حقل :attribute يجب ان يكون من النوع :values.',
    'min' => [
        'numeric' => 'حقل :attribute يجب ان يكون علي الاقل :min.',
        'file' => 'حقل :attribute يجب ان يكون علي الاقل :min kilobytes.',
        'string' => 'حقل :attribute يجب ان يكون علي الاقل :min حروف.',
        'array' => 'حقل :attribute must have at least :min items.',
    ],
    'multiple_of' => 'حقل :attribute must be a multiple of :value.',
    'not_in' => 'حقل selected :attribute غير صحيح.',
    'not_regex' => 'حقل :attribute format غير صحيح.',
    'numeric' => 'حقل :attribute يجب ان يكون ارقام فقط.',
    'password' => 'رجاء التأكد من كلمة المرور',
    'present' => 'حقل :attribute field must be present.',
    'prohibited' => 'حقل :attribute field is prohibited.',
    'prohibited_if' => 'حقل :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'حقل :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'حقل :attribute field prohibits :other from being present.',
    'regex' => 'حقل :attribute format غير صحيح.',
    'required' => 'حقل :attribute مطلوب.',
    'required_if' => 'حقل :attribute مطلوب عندما يكون :other يساوي :value.',
    'required_unless' => 'حقل :attribute مطلوب ما لم يكن :other يساوي :values.',
    'required_with' => 'حقل :attribute مطلوب عندما يكون :values is present.',
    'required_with_all' => 'حقل :attribute مطلوب عندما يكون :values are present.',
    'required_without' => 'حقل :attribute مطلوب عندما يكون :values is not present.',
    'required_without_all' => 'حقل :attribute field is required when none of :values are present.',
    'same' => 'حقل :attribute and :other must match.',
    'size' => [
        'numeric' => 'حقل :attribute يحب ان يكون :size.',
        'file' => 'حقل :attribute يحب ان يكون :size kilobytes.',
        'string' => 'حقل :attribute يحب ان يكون :size حروف.',
        'array' => 'حقل :attribute يجب ان يحتوي :size items.',
    ],
    'starts_with' => 'حقل :attribute must start with one of the following: :values.',
    'string' => 'حقل :attribute يجب ان يكون حروف فقط.',
    'timezone' => 'حقل :attribute must be a valid timezone.',
    'unique' => 'هذا :attribute مسجل يالفعل',
    'uploaded' => 'حقل :attribute failed to upload.',
    'url' => 'حقل :attribute must be a valid URL.',
    'uuid' => 'حقل :attribute must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'email' => 'البريد الأليكتروني',
        'username' => 'اسم المستخدم',
        'password' => 'كلمة المرور',
        'password_confirmation' => 'تاكيد كلمة المرور',
        'phone' => 'رقم الجوال',
        'country_id' => 'الدولة',
        'academic_year_id' => 'العام الدراسي',

        'classification_prefix' => 'بادئة القسائم',
        'classification_name' => 'اسم التصنيف',
        'color_class' => 'اللون المميز',
    ],

];
