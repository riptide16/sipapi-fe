<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AdminService;
use Alert;

class LoginController extends Controller
{
    public $endpoint;
    public $endpointMenu;
    private $admin;
    public function __construct(AdminService $admin)
    {
        $this->admin = $admin;
        $this->endpoint = 'auth/token';
        $this->endpointSelf = 'admin/self';

        $this->endpointMenu = 'admin/self/menus';
    }

    public function index()
    {
        if (session()->get('token') !== null) {
            session()->forget('token');
        }

        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $data = $request->all();
        $data['client_id'] = config('services.api.client_id');
        $data['client_secret'] = config('services.api.client_secret');
        $data['grant_type'] = config('services.api.grant_type');

        try {
            $login = $this->admin->createNew($this->endpoint, $data);

            if ($login['success'] == true) {
                $fetchDataMenu = $this->admin->getAll($this->endpointMenu, [], [
                    'Authorization' => 'Bearer ' . $login['data']['access_token']
                ]);

                $session = session(['token' => $login, 'menus' => $fetchDataMenu['data']]);

                $self = $this->admin->getAll($this->endpointSelf, [], [
                    'Authorization' => "Bearer " . $login['data']['access_token']
                ]);

                $user = session(['user' => $self]);

                $notifAll = $this->admin->getAll($this->endpointSelf.'/notifications/all', [], [
                    'Authorization' => "Bearer " . $login['data']['access_token']
                ]);
                $notif = $this->admin->getAll($this->endpointSelf.'/notifications', [], [
                    'Authorization' => "Bearer " . $login['data']['access_token']
                ]);

                $notification = session(['allNotifications' => $notifAll,'notifications' => $notif]);

                if (session('user')['data']['role']['name'] == 'asesor' && empty(session('user')['data']['province'])) {
                    return redirect(route('admin.profile'));
                }

                return redirect()->route('admin.dashboard')->with($session);
            } else {
                session()->flash('error', $login['message']);
                return redirect()->back()->withInput();
            }
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
            return redirect()->back();
        }
    }

    public function logout()
    {
        if (session()->get('token') !== null) {
            session()->forget('token');
        }

        return redirect()->route('login');
    }
}
