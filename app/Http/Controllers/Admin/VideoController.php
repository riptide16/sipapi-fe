<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\VideoRequest;
use App\Services\AdminService;

class VideoController extends Controller
{
    public $endpoint;
    private $admin;
    public function __construct(AdminService $admin)
    {
        $this->admin = $admin;
        $this->endpoint = 'admin/videos';
    }

    public function index()
    {
        $token = session('token.data.access_token');
        $fetchDataVideos = $this->admin->getAll($this->endpoint, [], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchDataVideos['code']) && $fetchDataVideos['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        return view('admin.video.index', compact('fetchDataVideos'));
    }

    public function create()
    {
        return view('admin.video.create');
    }

    public function store(VideoRequest $request)
    {
        $data = $request->all();

        try {
            $token = session('token.data.access_token');
            $video = $this->admin->createNew($this->endpoint, $data, [
                'Authorization' => "Bearer " . $token
            ]);

            if ($video['success'] == true) {
                session()->flash('success', $video['message']);

                return redirect()->route('admin.video.index');
            } else {
                session()->flash('error', $video['message']);
                return redirect()->back()->withInput();
            }
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());

            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $token = session('token.data.access_token');
        $fetchDataVideo = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token
        ]);

        $video = $fetchDataVideo['data'];

        return view('admin.video.edit', compact('video'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $token = session('token.data.access_token');

        try {
            $video = $this->admin->put($this->endpoint, $id, $data, [
                'Authorization' => "Bearer " . $token
            ]);
            if ($video['success'] == true) {
                session()->flash('success', $video['message']);

                return redirect()->route('admin.video.index');
            } else {
                session()->flash('error', $video['message']);

                return redirect()->back();
            }
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());

            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        $token = session('token.data.access_token');

        try {
            $video = $this->admin->deleteByID($this->endpoint, $id, [
                'Authorization' => "Bearer " . $token
            ]);

            if ($video['success'] == true) {
                return response()->json([
                    'status' => 'success',
                    'message' => $video['message']
                ]);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => $video['message']
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $token = session('token.data.access_token');
        $component = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token
        ]);

        $video = $component['data'];

        return view('admin.video.show', compact('video'));
    }
}
