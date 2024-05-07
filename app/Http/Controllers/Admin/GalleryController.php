<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Gallery\CreateRequest;
use App\Http\Requests\Admin\Gallery\UpdateRequest;
use App\Services\AdminService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public $endpoint;
    public $endpointAlbum;
    private $admin;

    public function __construct(AdminService $admin)
    {
        $this->endpoint = 'admin/galleries';
        $this->endpointAlbum = 'admin/gallery-albums';
        $this->admin = $admin;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getAll($this->endpoint, ['per_page' => -1], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        return view('admin.galleries.index', compact('fetchData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $token = session('token.data.access_token');
        $albums = $this->admin->getAll($this->endpointAlbum, [], [
            'Authorization' => "Bearer " . $token
        ]);

        return view('admin.galleries.create', compact('albums'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $data = $request->all();
        $token = session('token.data.access_token');
        $output = [];
        $output[] = [
            'name' => 'title',
            'contents' => $data['title']
        ];

        $output[] = [
            'name' => 'caption',
            'contents' => $data['caption']
        ];

        $output[] = [
            'name' => 'album',
            'contents' => $data['album']
        ];

        $output[] = [
            'name' => 'published_date',
            'contents' => Carbon::parse($data['published_date'])->format('Y-m-d H:i:s')
        ];

        $output[] = [
            'name' => 'is_homepage',
            'contents' => $data['is_homepage']
        ];

        if ($request->hasFile('image_file')) {
            $extension = $request->file('image_file')[0]->getClientOriginalExtension();
            $file = $request->file('image_file')[0];
            $output[] = [
                'name' => 'image_file',
                'contents' => fopen($file, 'r'),
                'filename' => 'gallery_' . date('YmdHis') . $extension
            ];
        }

        $gallery = $this->admin->formData($this->endpoint, $output, [
            'Authorization' => "Bearer " . $token
        ]);

        if ($gallery['success']) {
            session()->flash('success', $gallery['message']);

            return redirect()->route('admin.galeri.index');
        } else {
            session()->flash('error', $gallery['message']);

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        return view('admin.galleries.show', compact('fetchData'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token
        ]);
        $albums = $this->admin->getAll($this->endpointAlbum, [], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        return view('admin.galleries.edit', compact('fetchData', 'albums'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $data = $request->all();
        $token = session('token.data.access_token');
        $output = [];
        $output[] = [
            'name' => 'title',
            'contents' => $data['title']
        ];

        $output[] = [
            'name' => 'caption',
            'contents' => $data['caption']
        ];

        $output[] = [
            'name' => 'album',
            'contents' => $data['album']
        ];

        $output[] = [
            'name' => 'is_homepage',
            'contents' => $data['is_homepage']
        ];

        $output[] = [
            'name' => '_method',
            'contents' => 'PUT'
        ];

        if ($request->hasFile('image_file')) {
            $extension = $request->file('image_file')[0]->getClientOriginalExtension();
            $file = $request->file('image_file')[0];
            $output[] = [
                'name' => 'image_file',
                'contents' => fopen($file, 'r'),
                'filename' => 'gallery_' . date('YmdHis') . $extension
            ];
        }

        $gallery = $this->admin->formData($this->endpoint . '/' . $id, $output, [
            'Authorization' => "Bearer " . $token
        ]);

        if ($gallery['success']) {
            session()->flash('success', $gallery['message']);

            return redirect()->route('admin.galeri.index');
        } else {
            session()->flash('error', $gallery['message']);

            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $token = session('token.data.access_token');
        $gallery = $this->admin->deleteByID($this->endpoint, $id, [
            'Authorization' => "Bearer " . $token
        ]);

        if ($gallery['success']) {
            return response()->json([
                'status' => 'success',
                'message' => $gallery['message']
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => $gallery['message']
            ]);
        }
    }
}
