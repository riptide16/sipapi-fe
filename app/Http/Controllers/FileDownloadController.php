<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AdminService;

class FileDownloadController extends Controller
{
    public $endpoint;
    private $admin;

    public function __construct(AdminService $admin)
    {
        $this->endpoint = 'file_downloads';
        $this->admin = $admin;
    }

    public function index(Request $request)
    {
        $files = $this->admin->getAll(
            $this->endpoint, [
                'per_page' => 10,
                'page' => $request->page
            ], []);

        return view('public.layanan.unduh-berkas.index', compact('files'));
    }
}
