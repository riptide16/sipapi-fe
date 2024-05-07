<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class WilayahController extends Controller
{
    public $endpoint;
    public $endpointProvince;
    public $endpointProvinceRegion;
    public $endpointProvinceRegionAvailable;
    private $admin;

    public function __construct(AdminService $admin)
    {
        $this->admin = $admin;
        $this->endpoint = 'admin/regions';
        $this->endpointProvince = 'admin/provinces';
        $this->endpointProvinceRegionAvailable = 'admin/province_region/available';
        $this->endpointProvinceRegion = 'admin/province_region/region';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $fetchDataRegion = $this->admin->getAll($this->endpoint, $params, [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchDataRegion['success'])) {
            if (!$fetchDataRegion['success']) {
                echo '{
                    "data": [],
                    "recordsTotal": 0,
                    "recordsFiltered": 0
                }';
            } else {
                $regions = $fetchDataRegion['data'];

                $i = 0;
                $dataRegion = [];
                foreach ($regions as $key => $region) {
                    $dataRegion[$i]['no'] = $start + 1;
                    $dataRegion[$i]['region'] = $region['id'];
                    $dataRegion[$i]['name'] = $region['name'];
                    $dataRegion[$i]['provinces'] = count($region['provinces']);
                    $dataRegion[$i]['action'] = '';
                    $start++;
                    $i++;
                }

                $output = array(
                    "draw" => intval($data['draw']),
                    "recordsTotal" => $fetchDataRegion['meta']['total'],
                    "recordsFiltered" => $fetchDataRegion['meta']['total'],
                    "aaData" => $dataRegion
                );

                echo json_encode($output);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Session::forget('section');
        $token = session('token.data.access_token');
        $provinces = $this->admin->getAll($this->endpointProvinceRegionAvailable, ['per_page' => -1], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($provinces['code']) && $provinces['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        session()->push('section', 'regions');

        return view('admin.region.regions.create', compact('provinces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $provinceIds = implode(',', $data['province_ids']);

        $input = [
            'name' => $data['name'],
            'province_ids' => $provinceIds
        ];

        try {
            $token = session('token.data.access_token');
            $wilayah = $this->admin->createNew($this->endpoint, $input, [
                'Authorization' => "Bearer " . $token
            ]);

            if ($wilayah['success'] == true) {
                session()->flash('success', $wilayah['message']);
                session(['default_masterdata' => 'regions']);

                return redirect()->route('admin.master_data.index');
            } else {
                session()->flash('error', $wilayah['message']);
                return redirect()->back()->withInput();
            }
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());

            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Session::forget('section');
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token
        ]);

        $provinces = $this->admin->getByID($this->endpointProvinceRegion, $id, ['per_page' => -1], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        $wilayah = $fetchData['data'];

        $arrayProvinces = [];
        foreach ($wilayah['provinces'] as $key => $value) {
            $arrayProvinces[] = $value['id'];
        }

        session()->push('section', 'regions');

        return view('admin.region.regions.edit', compact('wilayah', 'provinces', 'arrayProvinces'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $provinceIds = implode(',', $data['province_ids']);
        $input = [
            'name' => $data['name'],
            'province_ids' => $provinceIds
        ];
        $token = session('token.data.access_token');
        try {
            $wilayah = $this->admin->put($this->endpoint, $id, $input, [
                'Authorization' => "Bearer " . $token
            ]);

            if ($wilayah['success'] == true) {
                session()->flash('success', $wilayah['message']);
                session(['default_masterdata' => 'regions']);

                return redirect()->route('admin.master_data.regions.show', ['region' => $id]);
            } else {
                session()->flash('error', $wilayah['message']);

                return redirect()->back();
            }
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());

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
        $wilayah = $this->admin->deleteByID($this->endpoint, $id, [
            'Authorization' => "Bearer " . $token
        ]);

        if ($wilayah['success']) {
            return response()->json([
                'status' => 'success',
                'message' => $wilayah['message']
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => $wilayah['message']
            ]);
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
        Session::forget('section');
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token
        ]);

        foreach ($fetchData['data']['provinces'] as $item) {
            $fetchDataProvince = $this->admin->getByID($this->endpointProvince, $item['id'], [], [
                'Authorization' => "Bearer " . $token
            ]);

            $provinces[] = $fetchDataProvince;
        }

        $dataWilayah = collect([
            'name' => $fetchData['data']['name'],
            'provinces' => $provinces
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        session()->push('section', 'regions');
        return view('admin.region.regions.show', compact('dataWilayah'));
    }
}
