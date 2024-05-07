<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\AdminService;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public $endpoint;
    public $endpointReset;
    private $admin;
    public function __construct(AdminService $admin)
    {
        $this->admin = $admin;
        $this->endpoint = 'auth/forgot_password';
        $this->endpointReset = 'auth/reset_password';
    }

    public function index()
    {
        return view('auth.forgot-password');
    }

    public function store(ForgotPasswordRequest $request)
    {
        $data = $request->all();

        try {
            $forgot = $this->admin->createNew($this->endpoint, $data);
            if ($forgot['success'] == true) {
                session()->flash('success', $forgot['message']);

                return redirect()->route('forgot_password.index');
            } else {
                session()->flash('error', $forgot['message']);

                return redirect()->back();
            }
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());

            return redirect()->back();
        }
    }

    public function edit(Request $request)
    {
        $data = $request->all();
        $token = $data['token'];
        $email = $data['email'];

        if (empty($token) || empty($email)) {
            abort(401, 'You haven\'t access');
        }

        return view('auth.reset-password', compact('token', 'email'));
    }

    public function update(ResetPasswordRequest $request, $token)
    {
        $data = $request->all();
        $data['token'] = $token;

        try {
            $forgot = $this->admin->createNew($this->endpointReset, $data);

            if ($forgot['success'] == true) {
                session()->flash('success', $forgot['message']);

                return redirect()->route('login');
            } else {
                session()->flash('error', $forgot['message']);

                return redirect()->back();
            }
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());

            return redirect()->back();
        }
    }
}
