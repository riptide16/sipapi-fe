<?php

namespace App\View\Components\Forms;

use App\Services\AdminService;
use Illuminate\View\Component;

class SelectRegion extends Component
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
        $this->endpoint = 'admin/self/regions';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $token = session('token.data.access_token');

        $fetchData = $this->admin->getAll($this->endpoint, [], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $regions = $fetchData['data'];

        return view('components.forms.select-region', compact('regions'));
    }
}
