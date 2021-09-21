<?php

namespace App\View\Components\Admin\FormFields;

use Illuminate\View\Component;

class Select extends Component
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
        public string $selected = '',
        public string $placeholder = 'Выберите один из вариантов',
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
        return view('components.admin.form-fields.select');
    }
}
