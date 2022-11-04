<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxWordsRule implements Rule
{
    public $max_words;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($max_words = 4)
    {
        $this->max_words =  $max_words;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->get_num_of_words($value) >= $this->max_words;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'رجاء ادخال :attribute  رباعي';
    }

    function get_num_of_words($string) {
        $string = preg_replace('/\s+/', ' ', trim($string));
        $words = explode(" ", $string);
        return count($words);
    }
}
