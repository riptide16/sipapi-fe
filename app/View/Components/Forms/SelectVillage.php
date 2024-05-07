<?php

namespace App\View\Components\Forms;

use App\Services\AdminService;
use Illuminate\View\Component;

class SelectVillage extends Component
{
    public $endpoint;
    private $admin;
    public $fill;
    public $placeholder;
    public $subdistrictId;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(AdminService $admin, $fill, $placeholder, $subdistrictId = null)
    {
        $this->admin = $admin;
        $this->fill = $fill;
        $this->placeholder = $placeholder;
        $this->endpoint = 'admin/self/villages';
        $this->subdistrictId = $subdistrictId;
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
        if (isset($this->subdistrictId)) {
            $params['subdistrict_id'] = $this->subdistrictId;
        }
        $fetchData = $this->admin->getAll($this->endpoint, $params, [
            'Authorization' => 'Bearer ' . $token
        ]);

        $villages = $fetchData['data'];

        return view('components.forms.select-village', compact('villages'));
    }
}
