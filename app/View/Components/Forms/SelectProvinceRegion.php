<?php

namespace App\View\Components\Forms;

use App\Services\AdminService;
use Illuminate\View\Component;

class SelectProvinceRegion extends Component
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
        $this->endpoint = 'admin/province_region/'.$fill.'/province';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $token = session('token.data.access_token');

        $params = [];
        $params['per_page'] = -1;
        $fetchData = $this->admin->getAll($this->endpoint, $params, [
            'Authorization' => 'Bearer ' . $token
        ]);

        $provinces = $fetchData['data'];

        return view('components.forms.select-province-region', compact('provinces'));
    }
}
