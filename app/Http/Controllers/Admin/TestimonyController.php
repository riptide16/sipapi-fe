<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Testimony\CreateRequest;
use App\Http\Requests\Admin\Testimony\UpdateRequest;
use App\Services\AdminService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TestimonyController extends Controller
{
    public $endpoint;
    private $admin;
    public function __construct(AdminService $admin)
    {
        $this->endpoint = 'admin/testimonies';
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

        return view('admin.testimony.index', compact('fetchData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.testimony.create');
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
            'name' => 'content',
            'contents' => $data['content']
        ];

        if ($request->hasFile('photo_file')) {
            $output[] = [
                'name' => 'photo_file',
                'contents' => fopen($data['photo_file'][0], 'r'),
                'filename' => 'testimony_' . date('YmdHis') . '.png'
            ];
        }

        $testimony = $this->admin->formData($this->endpoint, $output, [
            'Authorization' => "Bearer " . $token
        ]);

        if ($testimony['success']) {
            session()->flash('success', $testimony['message']);

            return redirect()->route('admin.testimoni.index');
        } else {
            session()->flash('error', $testimony['message']);

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

        return view('admin.testimony.show', compact('fetchData'));
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

        return view('admin.testimony.edit', compact('fetchData'));
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
            'name' => 'name',
            'contents' => $data['name']
        ];

        $output[] = [
            'name' => 'content',
            'contents' => $data['content']
        ];

        $output[] = [
            'name' => '_method',
            'contents' => 'PUT'
        ];

        if ($request->hasFile('photo_file')) {
            $output[] = [
                'name' => 'photo_file',
                'contents' => fopen($data['photo_file'][0], 'r'),
                'filename' => 'testimony_' . date('YmdHis') . '.png'
            ];
        }

        $testimony = $this->admin->formData($this->endpoint . '/' . $id, $output, [
            'Authorization' => "Bearer " . $token
        ]);

        if ($testimony['success']) {
            session()->flash('success', $testimony['message']);

            return redirect()->route('admin.testimoni.index');
        } else {
            session()->flash('error', $testimony['message']);

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
        $testimony = $this->admin->deleteByID($this->endpoint, $id, [
            'Authorization' => "Bearer " . $token
        ]);

        if ($testimony['success']) {
            return response()->json([
                'status' => 'success',
                'message' => $testimony['message']
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => $testimony['message']
            ]);
        }
    }
}
