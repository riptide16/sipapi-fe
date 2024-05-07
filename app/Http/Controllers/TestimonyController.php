<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AdminService;

class TestimonyController extends Controller
{
    public $endpointTestimony;
    private $admin;

    public function __construct(AdminService $admin)
    {
        $this->endpointTestimony = 'testimonies';
        $this->admin = $admin;
    }

    public function index(Request $request)
    {
        $testimonies = $this->admin->getAll(
            $this->endpointTestimony, [
                'per_page' => 6,
                'page' => $request->page
            ], []);

        return view('public.tentang-kami.testimoni', compact('testimonies'));
    }
}
