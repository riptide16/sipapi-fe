<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Village\CreateRequest;
use App\Http\Requests\Village\UpdateRequest;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VillageController extends Controller
{
    public $endpoint;
    public $endpointCity;
    public $endpointProvince;
    public $endpointSubdistrict;
    public $endpointRegion;

    private $admin;
    public function __construct(AdminService $admin)
    {
        $this->endpoint = 'admin/villages';
        $this->endpointSubdistrict = 'admin/subdistricts';
        $this->endpointProvince = 'admin/provinces';
        $this->endpointCity = 'admin/cities';
        $this->endpointRegion = 'admin/regions';

        $this->admin = $admin;
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
        $fetchDataVillage = $this->admin->getAll($this->endpoint, $params, [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchDataVillage['success'])) {
            if (!$fetchDataVillage['success']) {
                echo '{
                    "data": [],
                    "recordsTotal": 0,
                    "recordsFiltered": 0
                }';
            } else {
                $villages = $fetchDataVillage['data'];

                $i = 0;
                $dataVillages = [];
                foreach ($villages as $key => $village) {
                    $dataVillages[$i]['no'] = $start + 1;
                    $dataVillages[$i]['name'] = wordwrap($village['name'], 10, "<wbr>", true);
                    $dataVillages[$i]['action'] = '';
                    $dataVillages[$i]['village'] = $village['id'];
                    $dataVillages[$i]['province'] = wordwrap($village['subdistrict']['city']['province']['name'], 10, "<wbr>", true);
                    $dataVillages[$i]['city'] = wordwrap($village['subdistrict']['city']['name'], 10, "<wbr>", true);
                    $dataVillages[$i]['subdistrict'] = wordwrap($village['subdistrict']['name'], 10, "<wbr>", true);
                    $dataVillages[$i]['postal_code'] = $village['postal_code'];

                    $start++;
                    $i++;
                }

                $output = array(
                    "draw" => intval($data['draw']),
                    "recordsTotal" => $fetchDataVillage['meta']['total'],
                    "recordsFiltered" => $fetchDataVillage['meta']['total'],
                    "aaData" => $dataVillages
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
        session()->push('section', 'villages');
        return view('admin.region.villages.create');
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

        try {
            $token = session('token.data.access_token');
            $village = $this->admin->createNew($this->endpoint, $data, [
                'Authorization' => 'Bearer ' . $token
            ]);

            if ($village['success'] == true) {
                session()->flash('success', $village['message']);

                return redirect()->route('admin.master_data.villages.show', ['id' => $village['data']['id']]);
            } else {
                session()->flash('error', $village['message']);
                return redirect()->back()->withInput();
            }
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
            return redirect()->back()->withInput();
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
            'Authorization' => 'Bearer ' . $token
        ]);

        $village = $fetchData['data'];
        session()->push('section', 'villages');

        return view('admin.region.villages.show', compact('village'));
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

        $village = $fetchData['data'];

        $fetchDataSubdistrict = $this->admin->getByID($this->endpointSubdistrict, $village['subdistrict']['id'], [], [
            'Authorization' => "Bearer " . $token
        ]);

        $subdistrict = $fetchDataSubdistrict['data'];

        $fetchDataCity = $this->admin->getByID($this->endpointCity, $subdistrict['city']['id'], [], [
            'Authorization' => "Bearer " . $token
        ]);

        $city = $fetchDataCity['data'];

        $fetchDataProvince = $this->admin->getByID($this->endpointProvince, $city['province']['id'], [], [
            'Authorization' => "Bearer " . $token
        ]);

        $province = $fetchDataProvince['data'];
        session()->push('section', 'villages');

        return view('admin.region.villages.edit', compact('village', 'province', 'city', 'subdistrict'));
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
        try {
            $token = session('token.data.access_token');
            $village = $this->admin->updateByID($this->endpoint, $id, $data, [
                'Authorization' => "Bearer " . $token
            ]);

            if ($village['success'] == true) {
                session()->flash('success', $village['message']);

                return redirect()->route('admin.master_data.villages.show', ['id' => $id]);
            } else {
                session()->flash('error', $village['message']);
                return redirect()->back()->withInput();
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

        try {
            $village = $this->admin->deleteByID($this->endpoint, $id, [
                'Authorization' => "Bearer " . $token
            ]);

            if ($village['success'] == true) {
                return response()->json([
                    'status' => 'success',
                    'message' => $village['message']
                ]);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => $village['message']
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
}
