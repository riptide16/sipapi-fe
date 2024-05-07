<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\City\CreateRequest;
use App\Http\Requests\City\UpdateRequest;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CityController extends Controller
{
    public $endpoint;
    public $endpointProvince;
    private $admin;
    public function __construct(AdminService $admin)
    {
        $this->admin = $admin;
        $this->endpoint = 'admin/cities';

        $this->endpointProvince = 'admin/provinces';
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
        $fetchDataCity = $this->admin->getAll($this->endpoint, $params, [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchDataCity['success'])) {
            if (!$fetchDataCity['success']) {
                echo '{
                    "data": [],
                    "recordsTotal": 0,
                    "recordsFiltered": 0
                }';
            } else {
                $cities = $fetchDataCity['data'];

                $i = 0;
                $dataCities = [];
                foreach ($cities as $key => $city) {
                    $dataCities[$i]['no'] = $start + 1;
                    $dataCities[$i]['name'] = wordwrap($city['name'], 10, "<wbr>", true);
                    $dataCities[$i]['action'] = '';
                    $dataCities[$i]['city'] = $city['id'];
                    $dataCities[$i]['province'] = $city['province']['name'];

                    $start++;
                    $i++;
                }

                $output = array(
                    "draw" => intval($data['draw']),
                    "recordsTotal" => $fetchDataCity['meta']['total'],
                    "recordsFiltered" => $fetchDataCity['meta']['total'],
                    "aaData" => $dataCities
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
        session()->push('section', 'cities');
        return view('admin.region.cities.create');
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
            $city = $this->admin->createNew($this->endpoint, $data, [
                'Authorization' => 'Bearer ' . $token
            ]);

            if ($city['success'] == true) {
                session()->flash('success', $city['message']);

                return redirect()->route('admin.master_data.cities.show', ['id' => $city['data']['id']]);
            } else {
                session()->flash('error', $city['message']);

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
        $fetchDataCity = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $city = $fetchDataCity['data'];
        session()->push('section', 'cities');

        return view('admin.region.cities.show', compact('city'));
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
        $fetchDataCity = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $city = $fetchDataCity['data'];
        session()->push('section', 'cities');

        return view('admin.region.cities.edit', compact('city'));
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
            $city = $this->admin->updateByID($this->endpoint, $id, $data, [
                'Authorization' => 'Bearer ' . $token
            ]);

            if ($city['success'] == true) {
                session()->flash('success', $city['message']);

                return redirect()->route('admin.master_data.cities.show', ['id' => $city['data']['id']]);
            } else {
                session()->flash('error', $city['message']);

                return redirect()->back()->withInput();
            }
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
            return redirect()->back()->withInput();
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
            $city = $this->admin->deleteByID($this->endpoint, $id, [
                'Authorization' => "Bearer " . $token
            ]);

            if ($city['success'] == true) {
                return response()->json([
                    'status' => 'success',
                    'message' => $city['message']
                ]);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => $city['message']
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
