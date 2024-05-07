<?php

namespace App\View\Components;

use App\Services\AdminService;
use Illuminate\View\Component;

class AccreditationActions extends Component
{
    protected $admin;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(AdminService $admin)
    {
        $this->admin = $admin;
        $this->endpoint = 'admin/self/accreditation_actions';
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
            'Authorization' => "Bearer " . $token
        ]);

        $actions = [];
        if ($fetchData['success'] === true) {
            $actions = $fetchData['data']['available_types']; 
        }

        return view('components.accreditation-actions', compact('actions'));
    }
}
