<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProvinceRequest;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProvinceController extends Controller
{
    public $endpoint;
    private $admin;
    public function __construct(AdminService $admin)
    {
        $this->admin = $admin;
        $this->endpoint = 'admin/provinces';
    }

    public function index(Request $request)
    {
        $data       = $request->all();

        $search     = strtoupper(preg_replace('/[^A-Za-z0-9\- ]/', '', $data["search"]["value"]));

        $start      = $data['start'];
        $length     = $data['length'];

        $collumn    = $data["order"][0]["column"];
        $orderType  = $data["order"][0]["dir"];

        $page       = 0;
        if (!empty($data['page'])) {
            $page   = $data['page'];
        }

        $orderBy = 'created_at';
        if ($collumn == 1) {
            $orderBy = 'name';
        } else {
            $orderBy = 'created_at';
        }

        $params = [];
        $params['keyword'] = $search;
        $params['sort_by'] = $orderBy;
        $params['sort'] = $orderType;
        $params['page'] = $page;
        $params['per_page'] = $length ?? 20;
        $token = session('token.data.access_token');
        $fetchDataProvince = $this->admin->getAll($this->endpoint, $params, [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchDataProvince['success'])) {
            if (!$fetchDataProvince['success']) {
                echo '{
                    "data": [],
                    "recordsTotal": 0,
                    "recordsFiltered": 0
                }';
            } else {
                $provinces = $fetchDataProvince['data'];

                $i = 0;
                $dataProvinces = [];
                foreach ($provinces as $key => $province) {
                    $dataProvinces[$i]['no'] = $start + 1;
                    $dataProvinces[$i]['name'] = $province['name'];
                    $dataProvinces[$i]['action'] = '';
                    $dataProvinces[$i]['province'] = $province['id'];

                    $start++;
                    $i++;
                }

                $output = array(
                    "draw" => intval($data['draw']),
                    "recordsTotal" => $fetchDataProvince['meta']['total'],
                    "recordsFiltered" => $fetchDataProvince['meta']['total'],
                    "aaData" => $dataProvinces
                );

                echo json_encode($output);
            }
        }
    }

    public function show($id)
    {
        Session::forget('section');
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token
        ]);

        $province = $fetchData['data'];

        session()->push('section', 'provinces');

        return view('admin.region.provinces.show', compact('province'));
    }

    public function create()
    {
        Session::forget('section');
        session()->push('section', 'provinces');
        return view('admin.region.provinces.create');
    }

    public function store(ProvinceRequest $request)
    {
        $data = $request->all();

        try {
            $token = session('token.data.access_token');
            $province = $this->admin->createNew($this->endpoint, $data, [
                'Authorization' => "Bearer " . $token
            ]);

            if ($province['success'] == true) {
                session()->flash('success', $province['message']);

                return redirect()->route('admin.master_data.provinces.show', ['id' => $province['data']['id']]);
            } else {
                session()->flash('error', $province['message']);

                return redirect()->back()->withInput();
            }
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());

            return redirect()->back();
        }
    }

    public function edit($id)
    {
        Session::forget('section');
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token
        ]);

        $province = $fetchData['data'];
        session()->push('section', 'provinces');

        return view('admin.region.provinces.edit', compact('province'));
    }

    public function update(ProvinceRequest $request, $id)
    {
        $data = $request->all();

        try {
            $token = session('token.data.access_token');
            $province = $this->admin->put($this->endpoint, $id, $data, [
                'Authorization' => "Bearer " . $token
            ]);

            if ($province['success'] == true) {
                session()->flash('success', $province['message']);

                return redirect()->route('admin.master_data.provinces.show', ['id' => $id]);
            } else {
                session()->flash('error', $province['message']);

                return redirect()->back()->withInput();
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
            $province = $this->admin->deleteByID($this->endpoint, $id, [
                'Authorization' => "Bearer " . $token
            ]);

            if ($province['success'] == true) {
                return response()->json([
                    'status' => 'success',
                    'message' => $province['message']
                ]);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => $province['message']
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
}
