<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdminService;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public $endpoint;
    private $admin;

    public function __construct(AdminService $admin)
    {
        $this->endpoint = 'admin/self';
        $this->admin = $admin;
    }

    public function index()
    {
        $user = session('user.data');
        if (!$user) {
            $token = session('token.data.access_token');
            $fetchData = $this->admin->getAll($this->endpoint, [], [
                'Authorization' => "Bearer " . $token
            ]);

            if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
                return redirect()->route('logout');
            }
            $user = $fetchData['data'];
        }

        return view('admin.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $data = $request->only([
            'name', 'email', 'phone_number', 'region_id', 'institution_name', 'province_id',
            'password', 'password_confirmation', 'photo_upload'
        ]);

        $form = [];
        if ($request->hasFile('photo_upload')) {
            $extension = $request->file('photo_upload')[0]->getClientOriginalExtension();
            $file = $request->file('photo_upload')[0];
            $form[] = [
                'name' => 'photo_upload',
                'contents' => fopen($file, 'r'),
                'filename' => date('YmdHis') . '-photo.' . $extension
            ];

            unset($data['photo_upload']);
        }

        if (empty($data['password'])) {
            unset($data['password']);
            unset($data['password_confirmation']);
        }

        foreach ($data as $key => $formdata) {
            $form[] = [
                'name' => $key,
                'contents' => $formdata,
            ];
        }

        $token = session('token.data.access_token');
        $fetchData = $this->admin->postFileUpload($this->endpoint, $form, [
            'Authorization' => "Bearer " . $token,
            'user-agent' => $request->server('HTTP_USER_AGENT'),
            'ip-address' => $request->ip()
        ]);

        if (isset($fetchData['code'])) {
            switch ($fetchData['code']) {
                case 'ERR4001':
                    return redirect()->route('logout');
                case 'ERR4022':
                    throw ValidationException::withMessages($fetchData['errors']);
            }
        }

        if ($fetchData['success'] === true) {
            session(['user' => $fetchData]);
            $user = $fetchData['data'];
            session()->flash('success', 'Sukses update data');

            return redirect()->route('admin.profile');
        } else {
            session()->flash('error', $fetchData['message']);
            return redirect()->back()->withInput();
        }
    }
}
