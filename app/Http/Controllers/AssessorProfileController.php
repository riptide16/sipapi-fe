<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AdminService;

class AssessorProfileController extends Controller
{
    public $endpointAssessor;
    private $admin;

    public function __construct(AdminService $admin)
    {
        $this->endpointAssessor = 'assessor';
        $this->admin = $admin;
    }

    public function index(Request $request)
    {
        $assessors = $this->admin->getAll(
            $this->endpointAssessor, [
                'per_page' => 10,
                'page' => $request->page
            ], []);
        $currentPage = $request->page;

        return view('public.tentang-kami.asesor', compact('assessors', 'currentPage'));
    }

    public function show($id)
    {
        $assessor = $this->admin->getByID($this->endpointAssessor, $id, [], []);

        return view('public.tentang-kami.asesor-detail', compact('assessor'));
    }
}
