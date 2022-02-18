<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Courseboxmd extends Component
{
    public $courseDetails;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($courseDetails)
    {
        //
        $this->courseDetails = $courseDetails;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.courseboxmd');
    }
}
