<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AdminService;

class FAQController extends Controller
{
    public $endpoint;
    private $admin;

    public function __construct(AdminService $admin)
    {
        $this->endpoint = 'faqs';
        $this->admin = $admin;
    }

    public function index()
    {
        $faqs = $this->admin->getAll($this->endpoint, [], []);

        return view('public.layanan.faq.index', compact('faqs'));
    }
}
