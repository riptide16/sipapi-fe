<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Banner\CreateRequest;
use App\Http\Requests\Admin\Banner\UpdateRequest;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

use function Symfony\Component\DependencyInjection\Loader\Configurator\ref;

class BannerController extends Controller
{
    public $endpoint;
    private $admin;
    public function __construct(AdminService $admin)
    {
        $this->endpoint = 'admin/banners';
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

        return view('admin.banners.index', compact('fetchData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banners.create');
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
            'name' => 'name',
            'contents' => $data['name']
        ];

        $output[] = [
            'name' => 'order',
            'contents' => $data['order']
        ];

        $output[] = [
            'name' => 'url',
            'contents' => $data['url']
        ];

        $output[] = [
            'name' => 'is_active',
            'contents' => $data['is_active'],
        ];

        $output[] = [
            'name' => 'image_file',
            'contents' => fopen($data['image_file'], 'r'),
            'filename' => 'banner_' . date('YmdHis') . '.png'
        ];

        $banner = $this->admin->formData($this->endpoint, $output, [
            'Authorization' => "Bearer " . $token
        ]);

        if ($banner['success']) {
            session()->flash('success', $banner['message']);

            return redirect()->route('admin.banner.index');
        } else {
            if (isset($banner['code']) && $banner['code'] == 'ERR4022') {
                throw ValidationException::withMessages($banner['errors']);
            }
            session()->flash('error', $banner['message']);

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

        return view('admin.banners.show', compact('fetchData'));
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

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        return view('admin.banners.edit', compact('fetchData'));
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

        foreach ($request->except('_token', '_method', 'image_file') as $name => $content) {
            $output[] = [
                'name' => $name,
                'contents' => $content,
            ];
        }

        $output[] = [
            'name' => '_method',
            'contents' => 'PUT'
        ];

        if ($request->hasFile('image_file')) {
            $output[] = [
                'name' => 'image_file',
                'contents' => fopen($request->file('image_file'), 'r'),
                'filename' => 'banner_' . date('YmdHis') . '.png'
            ];
        }

        $banner = $this->admin->formData($this->endpoint . '/' . $id, $output, [
            'Authorization' => "Bearer " . $token
        ]);

        if ($banner['success']) {
            session()->flash('success', $banner['message']);

            return redirect()->route('admin.banner.show', [$id]);
        } else {
            if (isset($banner['code']) && $banner['code'] == 'ERR4022') {
                throw ValidationException::withMessages($banner['errors']);
            }
            session()->flash('error', $banner['message']);

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
        $banner = $this->admin->deleteByID($this->endpoint, $id, [
            'Authorization' => "Bearer " . $token
        ]);

        if ($banner['success']) {
            return response()->json([
                'status' => 'success',
                'message' => $banner['message']
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => $banner['message']
            ]);
        }
    }
}
