<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Services\AdminService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public $endpoint;
    private $admin;

    public function __construct(AdminService $admin)
    {
        $this->endpoint = 'admin/users';
        $this->admin = $admin;
    }

    public function index()
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getAll($this->endpoint, ['per_page' => -1], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        return view('admin.user.index', compact('fetchData'));
    }

    public function show($id)
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token
        ]);

        $user = $fetchData['data'];

        return view('admin.user.show', compact('user'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(UserRequest $request)
    {
        $data = $request->all();

        try {
            $token = session('token.data.access_token');
            $user = $this->admin->createNew($this->endpoint, $data, [
                'Authorization' => "Bearer " . $token
            ]);

            if ($user['success'] == true) {
                session()->flash('success', $user['message']);

                return redirect()->route('admin.user.create');
            } else {
                session()->flash('error', $user['message']);
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
        $fetchData = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token
        ]);

        $user = $fetchData['data'];

        return view('admin.user.edit', compact('user'));
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $data = $request->all();

        $token = session('token.data.access_token');

        try {
            $user = $this->admin->put($this->endpoint, $id, $data, [
                'Authorization' => "Bearer " . $token
            ]);

            if ($user['success'] == true) {
                session()->flash('success', $user['message']);

                return redirect()->route('admin.user.show', [$id]);
            } else {
                session()->flash('error', $user['message']);

                return redirect()->back();
            }
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());

            return redirect()->back();
        }
    }

    public function delete($id)
    {
        $token = session('token.data.access_token');

        try {
            $user = $this->admin->deleteByID($this->endpoint, $id, [
                'Authorization' => "Bearer " . $token
            ]);

            if ($user['success'] == true) {
                return response()->json([
                    'status' => 'success',
                    'message' => $user['message']
                ]);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => $user['message']
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
