<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Instrument\CreateRequest;
use App\Http\Requests\Admin\Instrument\UpdateRequest;
use App\Services\AdminService;
use Illuminate\Http\Request;

class InstrumentController extends Controller
{
    public $endpoint;
    private $admin;
    public function __construct(AdminService $admin)
    {
        $this->admin = $admin;
        $this->endpoint = 'admin/instruments';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getAll($this->endpoint, [], [
            'Authorization' => 'Bearer ' . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        return view('admin.instrument.index', compact('fetchData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.instrument.create');
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
            $instrument = $this->admin->createNew($this->endpoint, $data, [
                'Authorization' => "Bearer " . $token
            ]);

            if ($instrument['success'] == true) {
                session()->flash('success', $instrument['message']);

                return redirect()->route('admin.instruments.index');
            } else {
                session()->flash('error', $instrument['message']);
                return redirect()->back()->withInput();
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
    public function show($id)
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        return view('admin.instrument.show', compact('fetchData'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        return view('admin.instrument.edit', compact('fetchData'));
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
            $instrument = $this->admin->updateByID($this->endpoint, $id, $data, [
                'Authorization' => "Bearer " . $token
            ]);

            if ($instrument['success'] == true) {
                session()->flash('success', $instrument['message']);

                return redirect()->route('admin.instruments.index');
            } else {
                session()->flash('error', $instrument['message']);
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
            $instrument = $this->admin->deleteByID($this->endpoint, $id, [
                'Authorization' => "Bearer " . $token
            ]);

            if ($instrument['success'] == true) {
                return response()->json([
                    'status' => 'success',
                    'message' => $instrument['message']
                ]);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => $instrument['message']
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
