<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PageController extends Controller
{
    public $endpoint;
    private $admin;

    public function __construct(AdminService $admin)
    {
        $this->endpoint = 'admin/pages';
        $this->admin = $admin;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getAll($this->endpoint, ['per_page' => -1], [
            'Authorization' => "Bearer " . $token,
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        return view('admin.page.index', compact('fetchData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.page.create');
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

        $page = $this->admin->createNew($this->endpoint, $data, [
            'Authorization' => "Bearer " . $token
        ]);

        try {
            if ($page['success'] === true) {
                session()->flash('success', $page['message']);

                return redirect()->route('admin.content-website.page.index');
            } else {
                if (isset($page['code'])) {
                    switch($page['code']) {
                    case 'ERR4001':
                        return redirect()->route('logout');
                    case 'ERR4022':
                        throw ValidationException::withMessages($page['errors']);
                    }
                }
                session()->flash('error', $page['message']);
                return redirect()->back()->withInput();
            }
        } catch (ValidationException $e) {
            throw $e;
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
    public function show(Request $request, $id)
    {
        $token = session('token.data.access_token');
        $page = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token,
        ]);
        if ($page['success'] === false && $page['code'] == 'ERR4004') {
            abort(404);
        }
        $page = $page['data'];

        return view('admin.page.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $token = session('token.data.access_token');
        $page = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token,
        ]);
        if ($page['success'] === false && $page['code'] == 'ERR4004') {
            abort(404);
        }
        $page = $page['data'];

        return view('admin.page.edit', compact('page', 'id'));
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

        $token = session('token.data.access_token');

        $page = $this->admin->updateByID($this->endpoint, $id, $data, [
            'Authorization' => "Bearer " . $token
        ]);

        try {
            if ($page['success'] === true) {
                session()->flash('success', $page['message']);

                return redirect()->route('admin.content-website.page.show', [$id]);
            } else {
                if (isset($page['code'])) {
                    switch($page['code']) {
                    case 'ERR4001':
                        return redirect()->route('logout');
                    case 'ERR4022':
                        throw ValidationException::withMessages($page['errors']);
                    }
                }
                session()->flash('error', $page['message']);
                return redirect()->back()->withInput();
            }
        } catch (ValidationException $e) {
            throw $e;
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
    public function destroy(Request $request, $id)
    {
        $token = session('token.data.access_token');
        $result = $this->admin->deleteByID($this->endpoint, $id, [
            'Authorization' => "Bearer " . $token,
        ]);

        if ($result['success']) {
            return response()->json([
                'status' => 'success',
                'message' => $result['message']
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => $result['message']
            ]);
        }
    }

    public function checkSlugAvailability($slug)
    {
        $token = session('token.data.access_token');
        $result = $this->admin->getByID('admin/self/pages/slug_availability', $slug, [], [
            'Authorization' => "Bearer " . $token,
        ]);
        if (isset($result['success']) && $result['success'] === true) {
            return response()->json([
                'data' => $result['data'],
            ]);
        } else {
            return response()->json([
                'error' => $result['message'],
            ], 400);
        }
    }
}
