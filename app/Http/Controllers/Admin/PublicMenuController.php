<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PublicMenuController extends Controller
{
    public $endpoint;
    private $admin;

    public function __construct(AdminService $admin)
    {
        $this->endpoint = 'admin/public_menus';
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

        return view('admin.public_menu.index', compact('fetchData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.public_menu.create');
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

        $menu = $this->admin->createNew($this->endpoint, $data, [
            'Authorization' => "Bearer " . $token
        ]);

        try {
            if ($menu['success'] === true) {
                session()->flash('success', $menu['message']);

                return redirect()->route('admin.content-website.public-menu.index');
            } else {
                if (isset($menu['code'])) {
                    switch($menu['code']) {
                    case 'ERR4001':
                        return redirect()->route('logout');
                    case 'ERR4022':
                        throw ValidationException::withMessages($menu['errors']);
                    }
                }
                session()->flash('error', $menu['message']);
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
        $menu = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token,
        ]);
        if ($menu['success'] === false && $menu['code'] == 'ERR4004') {
            abort(404);
        }
        $menu = $menu['data'];

        return view('admin.public_menu.show', compact('menu'));
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
        $menu = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token,
        ]);
        if ($menu['success'] === false && $menu['code'] == 'ERR4004') {
            abort(404);
        }
        $menu = $menu['data'];

        return view('admin.public_menu.edit', compact('menu', 'id'));
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

        $menu = $this->admin->updateByID($this->endpoint, $id, $data, [
            'Authorization' => "Bearer " . $token
        ]);

        try {
            if ($menu['success'] === true) {
                session()->flash('success', $menu['message']);

                return redirect()->route('admin.content-website.public-menu.show', [$id]);
            } else {
                if (isset($menu['code'])) {
                    switch($menu['code']) {
                    case 'ERR4001':
                        return redirect()->route('logout');
                    case 'ERR4022':
                        throw ValidationException::withMessages($menu['errors']);
                    }
                }
                session()->flash('error', $menu['message']);
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
}
