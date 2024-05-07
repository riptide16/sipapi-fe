<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AdminService;

class VideoController extends Controller
{
    public $endpointVideo;
    private $admin;

    public function __construct(AdminService $admin)
    {
        $this->endpointVideo = 'videos';
        $this->admin = $admin;
    }

    public function index(Request $request)
    {
        $videos = $this->admin->getAll(
            $this->endpointVideo, [
                'per_page' => 4,
                'page' => $request->page
            ], []);

        $currentPage = $request->page;

        return view('public.media.video.index', compact('videos', 'currentPage'));
    }

    public function show($id)
    {
        $video = $this->admin->getByID($this->endpointVideo, $id, [], []);

        return view('public.media.video.show', compact('video'));
    }
}
