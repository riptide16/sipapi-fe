<?php

namespace App\View\Components\Forms;

use App\Services\AdminService;
use Illuminate\View\Component;

class SelectInstrumentFirst extends Component
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
    public function __construct(AdminService $admin, $fill, $placeholder, $parentId)
    {
        $this->admin = $admin;
        $this->endpoint = 'admin/instrument_components';

        $this->fill = $fill;
        $this->placeholder = $placeholder;
        $this->parentId = $parentId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $token = session('token.data.access_token');

        $param = http_build_query(['parent_id' => $this->parentId]);
        $components = $this->admin->getAll($this->endpoint.'?'.$param, [], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $collectFirstSubComponents = collect($components['data']);
        $filteredFirstSubComponents = $collectFirstSubComponents->filter(function ($value, $key) { 
            return $value['type'] == 'sub_1'; 
        });

        $instruments = array_values($filteredFirstSubComponents->toArray());

        return view('components.forms.select-instrument-first', compact('instruments'));
    }
}
