<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FileDownload\CreateRequest;
use App\Http\Requests\Admin\FileDownload\UpdateRequest;
use App\Services\AdminService;
use Illuminate\Http\Request;

class FileDownloadController extends Controller
{
    public $endpoint;
    private $admin;
    public function __construct(AdminService $admin)
    {
        $this->endpoint = 'admin/file_downloads';
        $this->admin = $admin;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getAll($this->endpoint, ['per_page' => -1], [
            'Authorization' => "Bearer " . $token,
            'user-agent' => $request->server('HTTP_USER_AGENT'),
            'ip-address' => $request->ip()
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        return view('admin.file-download.index', compact('fetchData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.file-download.create');
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
        $extentions = $request->file('attachment_file')->getClientOriginalExtension();
        $output = [];
        $output[] = [
            'name' => 'filename',
            'contents' => $data['filename']
        ];

        $output[] = [
            'name' => 'is_published',
            'contents' => $data['is_publish'] ?? 0
        ];

        $output[] = [
            'name' => 'attachment_file',
            'contents' => fopen($data['attachment_file'], 'r'),
            'filename' => 'file-download_' . date('YmdHis') . '.' . $extentions
        ];

        $result = $this->admin->formData($this->endpoint, $output, [
            'Authorization' => "Bearer " . $token,
            'user-agent' => $request->server('HTTP_USER_AGENT'),
            'ip-address' => $request->ip()
        ]);

        if ($result['success']) {
            session()->flash('success', $result['message']);

            return redirect()->route('admin.file-download.index');
        } else {
            session()->flash('error', $result['message']);

            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $token = session('token.data.access_token');
        $result = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token,
            'user-agent' => $request->server('HTTP_USER_AGENT'),
            'ip-address' => $request->ip()
        ]);

        return view('admin.file-download.show', compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $token = session('token.data.access_token');
        $result = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token,
            'user-agent' => $request->server('HTTP_USER_AGENT'),
            'ip-address' => $request->ip()
        ]);

        return view('admin.file-download.edit', compact('result'));
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
            'name' => 'filename',
            'contents' => $data['filename']
        ];

        $output[] = [
            'name' => 'is_published',
            'contents' => $data['is_publish'] ?? 0
        ];

        $output[] = [
            'name' => '_method',
            'contents' => 'put'
        ];

        if (isset($data['attachment_file'])) {
            $extentions = $request->file('attachment_file')->getClientOriginalExtension();
            $output[] = [
                'name' => 'attachment_file',
                'contents' => fopen($data['attachment_file'], 'r'),
                'filename' => 'file-download_' . date('YmdHis') . '.' . $extentions
            ];
        }

        $result = $this->admin->formData($this->endpoint . '/' . $id, $output, [
            'Authorization' => "Bearer " . $token,
            'user-agent' => $request->server('HTTP_USER_AGENT'),
            'ip-address' => $request->ip()
        ]);

        if ($result['success']) {
            session()->flash('success', $result['message']);

            return redirect()->route('admin.file-download.index');
        } else {
            session()->flash('error', $result['message']);

            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $token = session('token.data.access_token');
        $result = $this->admin->deleteByID($this->endpoint, $id, [
            'Authorization' => "Bearer " . $token,
            'user-agent' => $request->server('HTTP_USER_AGENT'),
            'ip-address' => $request->ip()
        ]);

        if ($result['success']) {
            return response()->json([
                'status' => 'success',
                'message' => $result['message']
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => $result['message']
            ]);
        }
    }
}
