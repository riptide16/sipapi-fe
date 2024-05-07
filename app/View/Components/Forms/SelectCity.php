<?php

namespace App\View\Components\Forms;

use App\Services\AdminService;
use Illuminate\View\Component;

class SelectCity extends Component
{
    public $endpoint;
    private $admin;
    public $fill;
    public $placeholder;
    public $provinceId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(AdminService $admin, $fill, $placeholder, $provinceId = null)
    {
        $this->admin = $admin;
        $this->fill = $fill;
        $this->placeholder = $placeholder;
        $this->endpoint = 'admin/self/cities';
        $this->provinceId = $provinceId;
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
        if (isset($this->provinceId)) {
            $params['province_id'] = $this->provinceId;
        }
        $fetchData = $this->admin->getAll($this->endpoint, $params, [
            'Authorization' => 'Bearer ' . $token
        ]);

        $cities = $fetchData['data'];

        return view('components.forms.select-city', compact('cities'));
    }
}
