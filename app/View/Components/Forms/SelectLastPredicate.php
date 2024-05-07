<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class SelectLastPredicate extends Component
{
    public $fill;
    public $placeholder;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($placeholder, $fill)
    {
        $this->fill = $fill;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $predicates = [
            [
                'id' => 'A',
                'name' => 'Akreditasi A'
            ],
            [
                'id' => 'B',
                'name' => 'Akreditasi B'
            ],
            [
                'id' => 'C',
                'name' => 'Akreditasi C'
            ],
            [
                'id' => 'Tidak Akreditasi',
                'name' => 'Tidak Akreditasi'
            ],
        ];

        return view('components.forms.select-last-predicate', compact('predicates'));
    }
}
