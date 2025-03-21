<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MonthlyDetail extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
    */
    public $user;
    public $total_earning;
    public $current_month_earning;


     public function __construct($user)
     {
        $this->user = $user;
     }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
    */
    public function render()
    {
        return view('lms::components.monthly-detail');
    }
}
