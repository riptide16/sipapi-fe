<?php

namespace App\View\Components\Forms;

use App\Services\AdminService;
use Illuminate\View\Component;

class SelectAsesor extends Component
{
    public $endpoint;
    private $admin;
    public $fill;
    public $placeholder;
    public $province;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(AdminService $admin, $fill, $placeholder, $province = null)
    {
        $this->admin = $admin;
        $this->fill = $fill;
        $this->placeholder = $placeholder;
        $this->endpoint = 'admin/users';
        $this->province = $province;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $token = session('token.data.access_token');
        $params = [
            'role:display_name' => 'asesor',
            'per_page' => -1,
            // 'province_id' => $this->province
        ];

        $asesors = $this->admin->getAll($this->endpoint, $params, [
            'Authorization' => 'Bearer ' . $token
        ]);

        return view('components.forms.select-asesor', compact('asesors'));
    }
}
