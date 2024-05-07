<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use Illuminate\Http\Request;

class AccessController extends Controller
{
    public $endpoint;
    public $endpointMenu;
    public $endpointPermission;
    private $admin;

    public function __construct(AdminService $admin)
    {
        $this->endpoint = 'admin/roles';
        $this->admin = $admin;

        $this->endpointMenu = 'admin/menus';
        $this->endpointPermission = 'admin/permissions';
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

        return view('admin.access.index', compact('fetchData'));
    }

    public function edit($id)
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        $fetchMenu = $this->admin->getAll($this->endpointMenu, [], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchMenu['code']) && $fetchMenu['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        $fetchDataPermission = $this->admin->getAll($this->endpointPermission, [], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchDataPermission['code']) && $fetchDataPermission['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        $dataPermissionAssign = [];

        foreach ($fetchData['data']['permissions'] as $key => $value) {
            $dataPermissionAssign[] = $value['id'];
        }

        return view('admin.access.edit', compact('fetchData', 'fetchMenu', 'dataPermissionAssign'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $data['permission_ids'] = implode(',', $data['action']);
        unset($data['action']);
        $token = session('token.data.access_token');
        $update = $this->admin->updateByID($this->endpoint, $id, $data, [
            'Authorization' => "Bearer " . $token
        ], 'permissions');

        if (isset($update['success'])) {
            if ($update['success']) {
                session()->flash('success', $update['message']);

                return redirect()->route('admin.access.index');
            } else {
                session()->flash('error', $update['message']);

                return redirect()->back();
            }
        } else {
            session()->flash('error', 'Cannot Get Response API');

            return redirect()->back();
        }
    }

    public function show($id)
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        $fetchMenu = $this->admin->getAll($this->endpointMenu, [], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchMenu['code']) && $fetchMenu['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        return view('admin.access.show', compact('fetchData', 'fetchMenu'));
    }
}
