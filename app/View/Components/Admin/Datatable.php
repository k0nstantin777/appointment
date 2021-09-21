<?php

namespace App\View\Components\Admin;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class Datatable extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public LengthAwarePaginator $collection)
    {

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.datatable');
    }
}
