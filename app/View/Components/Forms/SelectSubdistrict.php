<?php

namespace App\View\Components\Forms;

use App\Services\AdminService;
use Illuminate\View\Component;

class SelectSubdistrict extends Component
{
    public $endpoint;
    private $admin;
    public $fill;
    public $placeholder;
    public $cityId;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(AdminService $admin, $fill, $placeholder, $cityId = null)
    {
        $this->admin = $admin;
        $this->fill = $fill;
        $this->placeholder = $placeholder;
        $this->endpoint = 'admin/self/subdistricts';
        $this->cityId = $cityId;
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
        if (isset($this->cityId)) {
            $params['city_id'] = $this->cityId;
        }
        $fetchData = $this->admin->getAll($this->endpoint, $params, [
            'Authorization' => 'Bearer ' . $token
        ]);

        $subdistricts = $fetchData['data'];
        return view('components.forms.select-subdistrict', compact('subdistricts'));
    }
}
