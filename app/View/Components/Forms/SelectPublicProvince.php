<?php

namespace App\View\Components\Forms;

use App\Services\AdminService;
use Illuminate\View\Component;

class SelectPublicProvince extends Component
{
    public $endpoint;
    private $admin;
    public $fill;
    public $placeholder;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(AdminService $admin, $fill, $placeholder)
    {
        $this->admin = $admin;
        $this->fill = $fill;
        $this->placeholder = $placeholder;
        $this->endpoint = 'provinces';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $params = [];
        $params['per_page'] = -1;
        $fetchData = $this->admin->getAll($this->endpoint, $params);

        $provinces = $fetchData['data'];

        return view('components.forms.select-public-province', compact('provinces'));
    }
}
