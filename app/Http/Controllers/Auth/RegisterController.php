<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\RegisterAssessorRequest;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public $endpoint;
    private $admin;

    public function __construct(AdminService $admin)
    {
        $this->admin = $admin;
        $this->endpoint = 'auth/register';
    }

    public function index()
    {
        return view('auth.register');
    }

    public function indexAsesor()
    {
        return view('auth.register-asesor');
    }

    public function store(RegisterRequest $request)
    {
        $data = $request->all();
        $data['role_name'] = 'asesi';

        $register = $this->admin->createNew($this->endpoint, $data);
        dd($register);

        if ($register['success'] == true) {
            session()->flash('success_title', 'Akun berhasil dibuat');
            session()->flash('success', 'Silakan cek email Anda untuk melakukan aktivasi');

            return redirect()->route('login');
        } else {
            $messages = $this->checkMessageError($register['errors'], $data);
            session()->flash('error', $messages);

            return redirect()->back();
        }
    }

    public function storeAsesor(RegisterAssessorRequest $request)
    {
        $data = $request->all();
        $data['role_name'] = 'asesor';

        $register = $this->admin->createNew($this->endpoint, $data);

        if ($register['success'] == true) {
            session()->flash('success_title', 'Akun berhasil dibuat');
            session()->flash('success', 'Silakan cek email Anda untuk melakukan aktivasi');

            return redirect()->route('login');
        } else {
            if ($register['code'] == 'ERR4022') {
                throw ValidationException::withMessages($register['errors']);
            }
            $messages = $this->checkMessageError($register['errors'], $data);
            session()->flash('error', $messages);

            return redirect()->back();
        }
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha' => captcha_img()]);
    }

    private function checkMessageError($objects, $data)
    {
        $message = "";
        if (is_array($objects)) {
            foreach ($data as $key => $value) {
                foreach ($objects as $key2 => $value2) {
                    if ($key == $key2) {
                        $message = $value2[0];
                    }
                }
            }
        } else {
            $message = $objects;
        }
        return $message;
    }
}
