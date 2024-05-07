<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\InstrumentComponentRequest;
use App\Http\Requests\Admin\InstrumentComponentUpdateRequest;
use App\Http\Requests\Admin\InstrumentFirstSubComponentRequest;
use App\Http\Requests\Admin\InstrumentFirstSubComponentUpdateRequest;
use App\Http\Requests\Admin\InstrumentSecondSubComponentRequest;
use App\Http\Requests\Admin\InstrumentSecondSubComponentUpdateRequest;

class InstrumentComponentController extends Controller
{
    public $endpoint;
    public $endpointFirstSubComponent;
    public $endpointSecondSubComponent;
    private $admin;

    public function __construct(AdminService $admin)
    {
        $this->endpoint = 'admin/instrument_components';
        $this->admin = $admin;
    }

    public function index(Request $request)
    {
        $token = session('token.data.access_token');
        $components = $this->admin->getAll($this->endpoint.'?per_page=-1', [], [
            'Authorization' => "Bearer " . $token,
            'user-agent' => $request->server('HTTP_USER_AGENT'),
            'ip-address' => $request->ip()
        ]);

        if (isset($components['code']) && $components['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        $collectComponents = collect($components['data']);
        $filteredComponents = $collectComponents->filter(function ($value, $key) { 
            return $value['type'] == 'main';
        });

        $collectFirstSubComponents = collect($components['data']);
        $filteredFirstSubComponents = $collectFirstSubComponents->filter(function ($value, $key) { 
            return $value['type'] == 'sub_1';
        });

        $collectSecondSubComponents = collect($components['data']);
        $filteredSecondSubComponents = $collectSecondSubComponents->filter(function ($value, $key) { 
            return $value['type'] == 'sub_2';
        });

        $data = [
            'components' => $filteredComponents,
            'firstSubComponents' => array_values($filteredFirstSubComponents->toArray()),
            'secondSubComponents' => array_values($filteredSecondSubComponents->toArray()),
            'type' => $request->type ?? null
        ];

        return view('admin.instrument.component.index', $data);
    }

    public function show(Request $request, $id, $type)
    {
        $token = session('token.data.access_token');
        $component = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token,
            'user-agent' => $request->server('HTTP_USER_AGENT'),
            'ip-address' => $request->ip()
        ]);

        $instrument = $component['data'];

        return view('admin.instrument.component.show', compact('instrument', 'type'));
    }

    public function create($type)
    {
        return view('admin.instrument.component.create', compact('type'));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $token = session('token.data.access_token');
            $component = $this->admin->createNew($this->endpoint, $data, [
                'Authorization' => "Bearer " . $token,
                'user-agent' => $request->server('HTTP_USER_AGENT'),
                'ip-address' => $request->ip()
            ]);

            if ($component['success'] == true) {
                session()->flash('success', $component['message']);

                return redirect()->back();
            } else {
                $message = $this->convertMessage($component['errors'], $data);
                session()->flash('error', $message);
                return redirect()->back()->withInput();
            }
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());

            return redirect()->back();
        }
    }

    public function edit(Request $request, $id, $type)
    {
        $token = session('token.data.access_token');
        $component = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token,
            'user-agent' => $request->server('HTTP_USER_AGENT'),
            'ip-address' => $request->ip()
        ]);

        $instrument = $component['data'];

        return view('admin.instrument.component.edit', compact('instrument', 'type'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $token = session('token.data.access_token');

        try {
            $component = $this->admin->put($this->endpoint, $id, $data, [
                'Authorization' => "Bearer " . $token,
                'user-agent' => $request->server('HTTP_USER_AGENT'),
                'ip-address' => $request->ip()
            ]);

            if ($component['success'] == true) {
                session()->flash('success', $component['message']);

                return redirect()->route('admin.kategori_instrumen.show', ['id' => $id, 'type' => $data['type']]);
            } else {
                $message = $this->convertMessage($component['errors'], $data);
                session()->flash('error', $message);

                return redirect()->back();
            }
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());

            return redirect()->back();
        }
    }

    public function delete(Request $request, $id)
    {
        $token = session('token.data.access_token');

        try {
            $component = $this->admin->deleteByID($this->endpoint, $id, [
                'Authorization' => "Bearer " . $token,
                'user-agent' => $request->server('HTTP_USER_AGENT'),
                'ip-address' => $request->ip()
            ]);

            if ($component['success'] == true) {
                return response()->json([
                    'status' => 'success',
                    'message' => $component['message']
                ]);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => $component['message']
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function filter(Request $request)
    {
        $token = session('token.data.access_token');
        $query = http_build_query(array_merge($request->all(), ['per_page' => -1]));
        $components = $this->admin->getAll($this->endpoint.'?'.$query, [], [
            'Authorization' => "Bearer " . $token,
            'user-agent' => $request->server('HTTP_USER_AGENT'),
            'ip-address' => $request->ip()
        ]);

        return response()->json($components['data']);
    }

    private function convertMessage($obj, $data)
    {
        $message = null;
        if (is_array($obj)) {
            foreach ($data as $key => $value) {
                if (array_key_exists($key, $obj)) {
                    $message .= $obj[$key][0];
                }
            }
        } else {
            $message = $obj;
        }

        return $message;
    }
}
