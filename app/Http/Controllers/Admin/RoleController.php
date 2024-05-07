<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\RoleRequest;
use App\Http\Requests\Admin\RoleUpdateRequest;

class RoleController extends Controller
{
    public $endpoint;
    private $admin;

    public function __construct(AdminService $admin)
    {
        $this->endpoint = 'admin/roles';
        $this->admin = $admin;
    }

    public function index()
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getAll($this->endpoint, [], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        return view('admin.role.index', compact('fetchData'));
    }

    public function create()
    {
        return view('admin.role.create');
    }

    public function store(RoleRequest $request)
    {
        $data = $request->all();

        try {
            $token = session('token.data.access_token');
            $role = $this->admin->createNew($this->endpoint, $data, [
                'Authorization' => "Bearer " . $token
            ]);

            if ($role['success'] == true) {
                session()->flash('success', $role['message']);

                return redirect()->route('admin.roles.index');
            } else {
                session()->flash('error', $role['message']);
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

        $role = $fetchData['data'];

        return view('admin.role.edit', compact('role'));
    }

    public function update(RoleUpdateRequest $request, $id)
    {
        $data = $request->all();

        $token = session('token.data.access_token');

        try {
            $role = $this->admin->put($this->endpoint, $id, $data, [
                'Authorization' => "Bearer " . $token
            ]);

            if ($role['success'] == true) {
                session()->flash('success', $role['message']);

                return redirect()->route('admin.roles.index');
            } else {
                session()->flash('error', $role['message']);

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
            $role = $this->admin->deleteByID($this->endpoint, $id, [
                'Authorization' => "Bearer " . $token
            ]);

            if ($role['success'] == true) {
                return response()->json([
                    'status' => 'success',
                    'message' => $role['message']
                ]);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => $role['message']
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
