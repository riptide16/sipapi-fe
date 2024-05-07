<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Faq\CreateRequest;
use App\Http\Requests\Admin\Faq\UpdateRequest;
use App\Services\AdminService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public $endpoint;
    private $admin;
    public function __construct(AdminService $admin)
    {
        $this->endpoint = 'admin/faqs';
        $this->admin = $admin;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getAll($this->endpoint, ['per_page' => -1], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        return view('admin.faq.index', compact('fetchData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.faq.create');
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
            $faq = $this->admin->createNew($this->endpoint, $data, [
                'Authorization' => "Bearer " . $token
            ]);

            if ($faq['success'] == true) {
                session()->flash('success', $faq['message']);

                return redirect()->route('admin.faq.index');
            } else {
                session()->flash('error', $faq['message']);
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

        return view('admin.faq.show', compact('fetchData'));
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

        return view('admin.faq.edit', compact('fetchData'));
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
            $faq = $this->admin->put($this->endpoint, $id, $data, [
                'Authorization' => "Bearer " . $token
            ]);

            if ($faq['success'] == true) {
                session()->flash('success', $faq['message']);

                return redirect()->route('admin.faq.index');
            } else {
                session()->flash('error', $faq['message']);

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
        $faq = $this->admin->deleteByID($this->endpoint, $id, [
            'Authorization' => "Bearer " . $token
        ]);

        if ($faq['success']) {
            return response()->json([
                'status' => 'success',
                'message' => $faq['message']
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => $faq['message']
            ]);
        }
    }
}
