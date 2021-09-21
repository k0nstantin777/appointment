<?php

namespace App\View\Components\Admin\FormFields;

use Illuminate\View\Component;

class SelectMultiple extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $name,
        public string $label,
        public array $options,
        public array $selected = [],
        public string $placeholder = 'Выберите несколько вариантов',
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.form-fields.select-multiple');
    }
}
