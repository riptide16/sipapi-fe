<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AdminService;

class GalleryController extends Controller
{
    public $endpointGallery;
    public $endpointAlbum;
    private $admin;

    public function __construct(AdminService $admin)
    {
        $this->endpointGallery = 'gallery/albums';
        $this->endpointAlbum = 'albums';
        $this->admin = $admin;
    }

    public function index(Request $request)
    {
        $albums = $this->admin->getAll(
            $this->endpointAlbum, [
                'per_page' => 10,
                'page' => $request->page
            ], []);

        return view('public.media.galeri.index', compact('albums'));
    }

    public function galleryAlbum($slug, Request $request)
    {
        $galleries = $this->admin->getByID(
            $this->endpointGallery,
            $slug,
            [
                'per_page' => 10,
                'page' => $request->page
            ], []);

        return view('public.media.galeri.album', compact('galleries', 'slug'));
    }
}
