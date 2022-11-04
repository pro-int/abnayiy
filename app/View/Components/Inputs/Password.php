<?php

namespace App\View\Components\inputs;

use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class Password extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $name;
    public $inputclass;
    public $hasLabel;
    public $enableForgotPassword;

    public function __construct($name, $label = '', $enableForgotPassword = false, $inputclass = '')
    {
        $this->inputclass = $inputclass;
        $this->enableForgotPassword = $enableForgotPassword;
        $this->name = $name;
        $this->hasLabel = !empty($label);
        $this->label = $label;
    }

    public function label()
    {
        return $this->enableForgotPassword && Route::has('password.request') ? $this->HasForgetPassword() : $this->LabelOnly();
    }

    public function LabelOnly()
    {
        return $this->hasLabel ? "<label for='$this->name' class='form-label'>$this->label</label>" : null;
    }

    public function HasForgetPassword()
    {

        return "<div class='d-flex justify-content-between'>
            {$this->LabelOnly()} 
            <a href='". route('password.request')  ."'>
                <small>نسيت كلمة المرور ؟</small>
                </a>
                </div>";
    }



    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.inputs.password');
    }
}
