<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use Illuminate\Http\Request;

class VerifyController extends Controller
{
    public $endpoint;
    private $admin;
    public function __construct(AdminService $admin)
    {
        $this->admin = $admin;
        $this->endpoint = 'auth/verification';
    }

    public function index($token)
    {
        $result = $this->admin->createNew($this->endpoint, ['token' => $token]);

        if ($result['success'] == true) {
            session()->flash('success', 'Account is Verified!');

            return redirect()->route('login');
        } else {
            abort(404);
        }
    }
}
