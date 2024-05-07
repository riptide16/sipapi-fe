<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class SelectStatusUser extends Component
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
        $statuses = [
            [
                'id' => 'inactive',
                'name' => 'Menunggu Verifikasi'
            ],
            [
                'id' => 'active',
                'name' => 'Aktif'
            ],
            [
                'id' => 'failed',
                'name' => 'Ditolak'
            ]
        ];

        return view('components.forms.select-status-user', compact('statuses'));
    }
}
