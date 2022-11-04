<?php

namespace App\View\Components\ui;

use App\Helpers\Helpers;
use Illuminate\View\Component;

class Logo extends Component
{
    public $logoSrc;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $configData = Helpers::applClasses();
        $this->logoSrc = in_array($configData['theme'], ['dark', 'semi-dark']) ? 'assets/svglogo.svg'  : 'assets/reportLogo.png';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ui.logo');
    }
}
