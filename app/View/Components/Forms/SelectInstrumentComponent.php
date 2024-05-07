<?php

namespace App\View\Components\Forms;

use App\Services\AdminService;
use Illuminate\View\Component;

class SelectInstrumentComponent extends Component
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
    public function __construct(AdminService $admin, $fill, $placeholder, $category)
    {
        $this->admin = $admin;
        $this->endpoint = 'admin/instrument_components';

        $this->fill = $fill;
        $this->placeholder = $placeholder;
        $this->category = $category;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $token = session('token.data.access_token');

        $param = http_build_query(['category' => $this->category]);
        $components = $this->admin->getAll($this->endpoint.'?'.$param, [], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $collectComponents = collect($components['data']);
        $filteredComponents = $collectComponents->filter(function ($value, $key) { 
            return $value['type'] == 'main'; 
        });

        $instruments = $filteredComponents;

        return view('components.forms.select-instrument-component', compact('instruments'));
    }
}
