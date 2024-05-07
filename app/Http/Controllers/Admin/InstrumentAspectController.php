<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Instrument\Aspect\CreateRequest;
use App\Http\Requests\Admin\Instrument\Aspect\UpdateRequest;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

class InstrumentAspectController extends Controller
{
    public $endpoint;
    public $endpointComponent;
    public $admin;
    public function __construct(AdminService $admin)
    {
        $this->admin = $admin;
        $this->endpoint = 'admin/instruments';

        $this->endpointComponent = 'admin/instrument_components';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $instrument)
    {
        session()->forget('aspect-details');
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getAll($this->endpoint . '/' . $instrument . '/aspects', [], [
            'Authorization' => 'Bearer ' . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        $fetchDataInstrument = $this->admin->getByID($this->endpoint, $instrument, [], [
            'Authorization' => 'Bearer ' . $token
        ]);

        if (isset($fetchDataInstrument['code']) && $fetchDataInstrument['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        return view('admin.instrument.aspect.index', compact('fetchData', 'instrument', 'fetchDataInstrument'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $instrument)
    {
        $token = session('token.data.access_token');
        $fetchDataInstrument = $this->admin->getByID($this->endpoint, $instrument, [], [
            'Authorization' => 'Bearer ' . $token
        ]);

        if (isset($fetchDataInstrument['code']) && $fetchDataInstrument['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        $fetchDataComponent = $this->admin->getAll(
            $this->endpointComponent . "?category=" . $fetchDataInstrument['data']['category'] . '&type=main',
            [],
            [
                'Authorization' => "Bearer " . $token,
                'user-agent' => $request->server('HTTP_USER_AGENT'),
                'ip-address' => $request->ip()
            ]
        );

        return view('admin.instrument.aspect.create', compact(
            'fetchDataComponent',
            'instrument',
            'fetchDataInstrument'
        ));
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
        $token = session('token.data.access_token');

        $arrayChunk = array_chunk($data['opsi'], 5);

        $componentSubSecondId = 0;
        if (isset($data['component_sub_second_id']) && !empty($data['component_sub_second_id'])) {
            $componentSubSecondId = $data['component_sub_second_id'];
        } elseif (isset($data['component_sub_first_id']) && !empty($data['component_sub_first_id'])) {
            $componentSubSecondId = $data['component_sub_first_id'];
        } else {
            $componentSubSecondId = $data['component_id'];
        }

        $dataStore = [];
        $dataAspect = [];
        $dataChildren = [];
        $dataAspects = [];
        if ($data['type'] == 'choice') {
            foreach ($data['opsi'] as $key => $value) {
                if (!empty($value)) {
                    $dataStore[$key]['statement'] = $value;
                    $dataStore[$key]['order'] = $key + 1;
                }
            }
            $dataAspect[0]['aspect'] = $data['aspect'];
            $dataAspect[0]['type'] = $data['type'];
            $dataAspect[0]['order'] = $data['order'];
            $dataAspect[0]['instrument_component_id'] = $componentSubSecondId;
            $dataAspect[0]['points'] = $dataStore;

            $dataAspects['aspects'] = $dataAspect;
        } else {
            foreach ($data['sub_aspect'] as $key => $value) {
                $dataChildren[$key]['aspect'] = $value;
                foreach ($arrayChunk[$key] as $key2 => $value2) {
                    $dataStore[$key2]['statement'] = $value2;
                    $dataStore[$key2]['order'] = $key2 + 1;
                }
                $dataChildren[$key]['aspect'] = $value;
                $dataChildren[$key]['type'] = 'choice';
                $dataChildren[$key]['order'] = $key + 1;
                $dataChildren[$key]['points'] = $dataStore;
            }

            $dataAspect[0]['aspect'] = $data['aspect'];
            $dataAspect[0]['type'] = $data['type'];
            $dataAspect[0]['order'] = $data['order'];
            $dataAspect[0]['instrument_component_id'] = $componentSubSecondId;
            $dataAspect[0]['children'] = $dataChildren;

            $dataAspects['aspects'] = $dataAspect;
        }

        try {
            $store = $this->admin->createNew(
                $this->endpoint . '/' . $data['intrumentID'] . '/aspects/bulk',
                $dataAspects,
                [
                'Authorization' => "Bearer " . $token
                ]
            );

            if ($store['success'] == true) {
                session()->flash('success', $store['message']);

                return redirect()->route('admin.instruments.aspects.index', ['instrument' => $data['intrumentID']]);
            } else {
                session()->flash('error', $store['message']);

                return redirect()->back();
            }
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $instrument, $aspect)
    {
        $token = session('token.data.access_token');

        $fetchData = $this->admin->getByID($this->endpoint . '/' . $instrument . '/aspects', $aspect, [], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        $fetchDataInstrument = $this->admin->getByID($this->endpoint, $instrument, [], [
            'Authorization' => 'Bearer ' . $token
        ]);

        if (isset($fetchDataInstrument['code']) && $fetchDataInstrument['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        $fetchDataComponent = $this->admin->getAll($this->endpointComponent . "?category=" . $fetchDataInstrument['data']['category'] . '&type=main', [], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        $fetchDataComponentSub1 = $this->admin->getAll($this->endpointComponent . "?category=" . $fetchDataInstrument['data']['category'] . '&type=sub_1', [], [
            'Authorization' => "Bearer " . $token
        ]);

        $fetchDataComponentSub2 = $this->admin->getAll($this->endpointComponent . "?category=" . $fetchDataInstrument['data']['category'] . '&type=sub_2', [], [
            'Authorization' => "Bearer " . $token
        ]);

        return view('admin.instrument.aspect.show', compact(
            'fetchData',
            'instrument',
            'fetchDataComponent',
            'fetchDataInstrument',
            'fetchDataComponentSub2',
            'fetchDataComponentSub1'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $instrument, $aspect)
    {
        $token = session('token.data.access_token');

        $fetchData = $this->admin->getByID($this->endpoint . '/' . $instrument . '/aspects', $aspect, [], [
            'Authorization' => "Bearer " . $token
        ]);

        $fetchDataInstrument = $this->admin->getByID($this->endpoint, $instrument, [], [
            'Authorization' => 'Bearer ' . $token
        ]);

        if (isset($fetchDataInstrument['code']) && $fetchDataInstrument['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        $fetchDataComponent = $this->admin->getAll($this->endpointComponent . "?category=" . $fetchDataInstrument['data']['category'] . '&type=main', [], [
            'Authorization' => "Bearer " . $token
        ]);

        $filter1 = null;
        $filter2 = null;
        if (
            !empty($fetchData['data']['instrument_component']['parent']) &&
            count($fetchData['data']['instrument_component']['parent']) > 0 &&
            !empty($fetchData['data']['instrument_component']['parent']['parent']) &&
            count($fetchData['data']['instrument_component']['parent']['parent']) > 0
        ) {
            $filter1 = $fetchData['data']['instrument_component']['parent']['parent']['id'];
        }

        if (
            isset($fetchData['data']['instrument_component']['parent']) &&
            count($fetchData['data']['instrument_component']['parent']) > 0 &&
            isset($fetchData['data']['instrument_component']['parent']['parent']) &&
            count($fetchData['data']['instrument_component']['parent']['parent']) > 0
        ) {
            $filter2 = $fetchData['data']['instrument_component']['parent']['id'];
        }

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        $fetchDataComponentSub1 = $this->admin->getAll(
            $this->endpointComponent . "?category=" . $fetchDataInstrument['data']['category'] .
                '&type=sub_1&parent_id=' . $filter1,
            [],
            [
                'Authorization' => "Bearer " . $token,
                'user-agent' => $request->server('HTTP_USER_AGENT'),
                'ip-address' => $request->ip()
            ]
        );

        $fetchDataComponentSub2 = $this->admin->getAll(
            $this->endpointComponent . "?category=" . $fetchDataInstrument['data']['category'] .
                '&type=sub_2&parent_id=' . $filter2,
            [],
            [
                'Authorization' => "Bearer " . $token,
                'user-agent' => $request->server('HTTP_USER_AGENT'),
                'ip-address' => $request->ip()
            ]
        );

        return view('admin.instrument.aspect.edit', compact(
            'fetchData',
            'instrument',
            'fetchDataComponent',
            'fetchDataInstrument',
            'fetchDataComponentSub2',
            'fetchDataComponentSub1'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $aspect)
    {
        $data = $request->all();
        $token = session('token.data.access_token');

        $arrayChunk = array_chunk($data['opsi'], 5);

        $componentSubSecondId = 0;
        if (isset($data['component_sub_second_id']) && !empty($data['component_sub_second_id'])) {
            $componentSubSecondId = $data['component_sub_second_id'];
        } elseif (isset($data['component_sub_first_id']) && !empty($data['component_sub_first_id'])) {
            $componentSubSecondId = $data['component_sub_first_id'];
        } else {
            $componentSubSecondId = $data['component_id'];
        }

        $dataStore = [];
        $dataAspect = [];
        $dataChildren = [];
        $dataAspects = [];
        if ($data['type'] == 'choice') {
            foreach ($data['opsi'] as $key => $value) {
                $dataOpsi[$key]['statement'] = $value;
                $dataOpsi[$key]['order'] = $key + 1;
            }

            $dataAspects = [];
            $dataStore[] = [
                'id' => $aspect,
                'aspect' => $data['aspect'],
                'type' => $data['type'],
                'instrument_component_id' => $componentSubSecondId,
                'order' => $data['order'],
                'points' => $dataOpsi
            ];

            $dataAspects['aspects'] = $dataStore;
        } else {
            foreach ($data['sub_aspect'] as $key => $value) {
                $dataChildren[$key]['aspect'] = $value;
                foreach ($arrayChunk[$key] as $key2 => $value2) {
                    $dataStore[$key2]['statement'] = $value2;
                    $dataStore[$key2]['order'] = $key2 + 1;
                }
                $dataChildren[$key]['aspect'] = $value;
                $dataChildren[$key]['type'] = 'choice';
                $dataChildren[$key]['order'] = $key + 1;
                $dataChildren[$key]['points'] = $dataStore;
            }

            $dataAspect[0]['aspect'] = $data['aspect'];
            $dataAspect[0]['type'] = $data['type'];
            $dataAspect[0]['order'] = $data['order'];
            $dataAspect[0]['instrument_component_id'] = $componentSubSecondId;
            $dataAspect[0]['children'] = $dataChildren;

            $dataAspects['aspects'] = $dataAspect;
        }

        try {
            $store = $this->admin->updateByID(
                $this->endpoint,
                $data['intrumentID'],
                $dataAspects,
                [
                    'Authorization' => "Bearer " . $token,
                    'user-agent' => $request->server('HTTP_USER_AGENT'),
                    'ip-address' => $request->ip()
                ],
                'aspects/bulk'
            );

            if ($store['success'] == true) {
                session()->flash('success', $store['message']);

                return redirect()->route('admin.instrumen.aspects.show', ['instrument' => $data['intrumentID'], 'aspect' => $aspect]);
            } else {
                session()->flash('error', $store['message']);

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
    public function destroy(Request $request, $instrument, $aspect)
    {
        $token = session('token.data.access_token');

        $delete = $this->admin->deleteByID($this->endpoint, $instrument, [
            'Authorization' => "Bearer " . $token
        ], 'aspects', $aspect);

        if ($delete['success']) {
            return response()->json([
                'status' => 'success',
                'message' => $delete['message']
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => $delete['message']
            ]);
        }
    }

    public function addField(Request $request)
    {
        $data = $request->all();

        $dataOpsi = [];
        foreach ($data['opsi'] as $key => $value) {
            $dataOpsi[$key]['statement'] = $value;
            $dataOpsi[$key]['order'] = $key + 1;
        }

        $dataAspects = [
            'aspect' => $data['aspect'],
            'type' => $data['type'],
            'order' => $data['order'],
            'instrument_component_id' => $data['instrument_component_id'],
            'opsi' => $dataOpsi
        ];

        session()->push('aspect-details', $dataAspects);

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function removeField(Request $request)
    {
        $data = $request->all();

        $key = $data['key'];

        Session::get('aspect-details')[$key];
        Session::forget(['aspect-details.' . $key]);

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function getSubComponentAspect(Request $request)
    {
        $token = session('token.data.access_token');
        $subFirst = (isset($request->is_first)) ? $request->is_first : false;
        $subSecond = (isset($request->is_second)) ? $request->is_second : false;
        $params = [];

        if ($subFirst && $subSecond) {
            $params = [
                'per_page' => -1,
                'type' => 'sub_2',
                'parent_id' => $subSecond
            ];
        }

        if ($subFirst && !$subSecond) {
            $params = [
                'per_page' => -1,
                'type' => 'sub_1',
                'parent_id' => $subFirst
            ];
        }

        $fetchSubComponent = $this->admin->getAll($this->endpointComponent, $params, [
            'Authorization' => "Bearer " . $token
        ]);

        return response()->json($fetchSubComponent);
    }
}
