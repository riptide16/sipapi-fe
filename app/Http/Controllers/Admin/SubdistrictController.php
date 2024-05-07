<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subdistrict\CreateRequest;
use App\Http\Requests\Subdistrict\UpdateRequest;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubdistrictController extends Controller
{
    public $endpoint;
    public $endpointCity;
    public $endpointProvince;
    public $endpointVillage;
    public $endpointRegion;

    private $admin;

    public function __construct(AdminService $admin)
    {
        $this->endpoint = 'admin/subdistricts';
        $this->endpointProvince = 'admin/provinces';
        $this->endpointCity = 'admin/cities';
        $this->endpointVillage = 'admin/villages';
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
        $fetchDataSubdistrict = $this->admin->getAll($this->endpoint, $params, [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchDataSubdistrict['success'])) {
            if (!$fetchDataSubdistrict['success']) {
                echo '{
                    "data": [],
                    "recordsTotal": 0,
                    "recordsFiltered": 0
                }';
            } else {
                $subdistricts = $fetchDataSubdistrict['data'];

                $i = 0;
                $dataSubdistricts = [];
                foreach ($subdistricts as $key => $subdistrict) {
                    $dataSubdistricts[$i]['no'] = $start + 1;
                    $dataSubdistricts[$i]['name'] = wordwrap($subdistrict['name'], 10, "<wbr>", true);
                    $dataSubdistricts[$i]['action'] = '';
                    $dataSubdistricts[$i]['subdistrict'] = $subdistrict['id'];
                    $dataSubdistricts[$i]['province'] = wordwrap($subdistrict['city']['province']['name'], 10, "<wbr>", true);
                    $dataSubdistricts[$i]['city'] = wordwrap($subdistrict['city']['name'], 10, "<wbr>", true);

                    $start++;
                    $i++;
                }

                $output = array(
                    "draw" => intval($data['draw']),
                    "recordsTotal" => $fetchDataSubdistrict['meta']['total'],
                    "recordsFiltered" => $fetchDataSubdistrict['meta']['total'],
                    "aaData" => $dataSubdistricts
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
        session()->push('section', 'subdistricts');
        return view('admin.region.subdistricts.create');
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
            $subdistrict = $this->admin->createNew($this->endpoint, $data, [
                'Authorization' => 'Bearer ' . $token
            ]);

            if ($subdistrict['success'] == true) {
                session()->flash('success', $subdistrict['message']);

                return redirect()->route('admin.master_data.subdistricts.show', ['id' => $subdistrict['data']['id']]);
            } else {
                session()->flash('error', $subdistrict['message']);

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

        $subdistrict = $fetchData['data'];
        session()->push('section', 'subdistricts');

        return view('admin.region.subdistricts.show', compact('subdistrict'));
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

        $subdistrict = $fetchData['data'];

        $fetchDataCity = $this->admin->getByID($this->endpointCity, $subdistrict['city']['id'], [], [
            'Authorization' => "Bearer " . $token
        ]);

        $fetchDataProvince = $this->admin->getByID($this->endpointProvince, $fetchDataCity['data']['province']['id'], [], [
            'Authorization' => "Bearer " . $token
        ]);

        session()->push('section', 'subdistricts');

        return view('admin.region.subdistricts.edit', compact('subdistrict', 'fetchDataProvince'));
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
            $subdistrict = $this->admin->updateByID($this->endpoint, $id, $data, [
                'Authorization' => "Bearer " . $token
            ]);

            if ($subdistrict['success'] == true) {
                session()->flash('success', $subdistrict['message']);

                return redirect()->route('admin.master_data.subdistricts.show', ['id' => $subdistrict['data']['id']]);
            } else {
                session()->flash('error', $subdistrict['message']);
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
            $subdistrict = $this->admin->deleteByID($this->endpoint, $id, [
                'Authorization' => "Bearer " . $token
            ]);

            if ($subdistrict['success'] == true) {
                return response()->json([
                    'status' => 'success',
                    'message' => $subdistrict['message']
                ]);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => $subdistrict['message']
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
}
