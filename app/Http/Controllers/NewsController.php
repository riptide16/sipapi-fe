<?php

namespace App\Http\Controllers;

use App\Services\AdminService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public $endpointNews;
    private $admin;

    public function __construct(AdminService $admin)
    {
        $this->endpointNews = 'news';
        $this->admin = $admin;
    }

    public function index(Request $request)
    {
        $news = $this->admin->getAll(
            $this->endpointNews, [
                'per_page' => 10,
                'page' => $request->page
            ], []);

        return view('public.media.berita.index', compact('news'));
    }

    public function show($id)
    {
        $news = $this->admin->getByID($this->endpointNews, $id, [], []);

        return view('public.media.berita.show', compact('news'));
    }
}
