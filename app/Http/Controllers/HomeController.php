<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AdminService;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{
    public $endpointBanner;
    public $endpointNews;
    public $endpointVideo;
    public $endpointGallery;
    public $endpointTestimony;
    public $endpointInfographics;
    public $endpointPublicMenu;
    public $endpointPage;
    public $endpointInfographicMapping;
    public $endpointAssessor;
    private $admin;

    public function __construct(AdminService $admin)
    {
        $this->endpointBanner = 'banners';
        $this->endpointNews = 'news';
        $this->endpointVideo = 'home/videos';
        $this->endpointGallery = 'galleries';
        $this->endpointTestimony = 'testimonies';
        $this->endpointInfographics = 'infographics';
        $this->endpointPublicMenu = 'public_menus';
        $this->endpointPage = 'pages';
        $this->endpointInfographicMapping = 'infographics-mapping';
        $this->endpointAssessor = 'assessor';
        $this->admin = $admin;
    }

    public function index()
    {
        $banners = $this->admin->getAll($this->endpointBanner, [], []);
        $news = $this->admin->getAll($this->endpointNews, ['per_page' => 4], []);
        $videos = $this->admin->getAll($this->endpointVideo, ['per_page' => 4], []);
        $galleries = $this->admin->getAll($this->endpointGallery, [], []);
        $testimonies = $this->admin->getAll($this->endpointTestimony, [], []);
        $infographics = $this->admin->getAll($this->endpointInfographics, [], []);
        $publicMenu = $this->admin->getAll($this->endpointPublicMenu, [], []);
        $infographicsMapping = $this->admin->getAll($this->endpointInfographicMapping, [], []);
        $assessors = $this->admin->getAll($this->endpointAssessor, [
            'per_page' => 4,
            'is_homepage' => true
        ], []);

        session(['publicMenu' => $publicMenu]);

        $data = [
            'banners' => $banners,
            'news' => $news,
            'videos' => $videos,
            'galleries' => $galleries,
            'testimonies' => $testimonies,
            'infographics' => $infographics,
            'infographicsMapping' => $infographicsMapping,
            'assessors' => $assessors
        ];

        return view('public.index', $data);
    }

    public function dynamicMenu()
    {
        $url = request()->segment(2).'/'.request()->segment(3);
        $pages = $this->admin->getByID($this->endpointPage, $url, [], []);

        $data = [
            'pages' => $pages
        ];

        return view('public.page', $data);
    }
}
