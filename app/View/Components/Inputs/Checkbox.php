<?php

namespace App\View\Components\inputs;

use Illuminate\View\Component;

class Checkbox extends Component
{
    public $name;
    public $inputclass;

    public function __construct($name,$inputclass = '')
    {
        $this->inputclass = $inputclass;
        $this->name = $name;
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.inputs.checkbox');
    }
}
