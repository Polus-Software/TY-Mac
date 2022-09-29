<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Nodatafound extends Component
{
    public $message;
    public $notype;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($message, $notype)
    {
        $this->message = $message;
        $this->notype = $notype;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.nodatafound');
    }
}
