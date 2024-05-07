<?php

namespace App\View\Components;

use App\Services\AdminService;
use Illuminate\View\Component;

class FileDownloadUrl extends Component
{
    protected $admin;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(AdminService $admin, $filename)
    {
        $this->admin = $admin;
        $this->endpoint = 'admin/self/file_downloads';
        $this->filename = $filename;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getAll($this->endpoint, ['filename' => $this->filename], [
            'Authorization' => "Bearer " . $token
        ]);

        $url = '#';
        if ($fetchData['success'] === true) {
            $url = $fetchData['data'][0]['attachment'] ?? '#';
        }

        return view('components.file-download-url', [
            'url' => $url,
            'filename' => $this->filename
        ]);
    }
}
