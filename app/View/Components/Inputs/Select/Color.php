<?php

namespace App\View\Components\inputs\select;

use App\Helpers\Helpers;
use Illuminate\View\Component;

class Color extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $name;
    public $inputclass;
    public $hasLabel;
    public $clolrsData;

    public function __construct($name, $label = '', $inputclass = '', $clolrsData = [])
    {
        $this->inputclass = $inputclass;
        $this->name = $name;
        $this->hasLabel = !empty($label);
        $this->label = $label;
        $this->clolrsData = Helpers::Colors();
    }

    public function label()
    {

        return $this->hasLabel ? "<label for='$this->name' class='form-label'>$this->label</label>" : null;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.inputs.select.color');
    }
}
