<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class InstitutionController extends Controller
{
    public $endpointInstitution;
    public $endpointRegion;
    public $endpointProvince;
    public $endpointCity;
    public $endpointSubdistrict;
    public $endpointVillage;
    public $endpointInstutionAssessee;
    private $admin;

    public function __construct(AdminService $admin)
    {
        $this->endpointInstitution = 'admin/institutions';
        $this->endpointRegion = 'admin/regions';
        $this->endpointProvince = 'admin/provinces';
        $this->endpointCity = 'admin/cities';
        $this->endpointSubdistrict = 'admin/subdistricts';
        $this->endpointVillage = 'admin/villages';
        $this->endpointInstutionAssessee = 'admin/self/institution';
        $this->admin = $admin;
    }

    public function index(Request $request)
    {
        $token = session('token.data.access_token');
        $role = session()->get('user.data.role.name');
        $dataFilter = $request->all();
        // dd($dataFilter);
        $dataFilter1=array('datatype'=>'request');
        // dd($dataFilter1);
        if($dataFilter===$dataFilter1 || $dataFilter===[]){
            
        $dataFilter=array('status'=>'menunggu_verifikasi');
      
        }
       
        $dataFilter['datatype'] = $request->datatype ?? 'request';
        // dd($dataFilter);
        
        
        if ($role == 'asesi') {
            $fetchDataInstitution = $this->admin->getAll($this->endpointInstutionAssessee, $dataFilter, [
                'Authorization' => "Bearer " . $token
            ]);
           

            if (!empty($fetchDataInstitution['data']['status']) && $fetchDataInstitution['data']['status'] == 'tidak_valid') {
                session()->flash('invalid_institution', true);
            }

            if (isset($fetchDataInstitution['code']) && $fetchDataInstitution['code'] == 'ERR4001') {
                return redirect()->route('logout');
            }

            if (empty($fetchDataInstitution['data'])) {
                return view('admin.institution.create');
            }

            $isAsesi = true;

            return view('admin.institution.show', compact('fetchDataInstitution', 'isAsesi'));
        } else {
            $fetchDataInstitution = $this->admin->getAll($this->endpointInstitution, $dataFilter, [
                'Authorization' => "Bearer " . $token
            ]);
            // dd($fetchDataInstitution);

            if (isset($fetchDataInstitution['code']) && $fetchDataInstitution['code'] == 'ERR4001') {
                return redirect()->route('logout');
            }

            return view('admin.institution.index', compact('fetchDataInstitution', 'dataFilter'));
        }
    }

    public function show(Request $request, $id)
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getByID($this->endpointInstitution, $id . '?datatype='.$request->datatype ?? 'valid', [], [
            'Authorization' => "Bearer " . $token
        ]);

        $data = [
            'fetchDataInstitution' => $fetchData,
        ];

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        return view('admin.institution.show', $data);
    }

    public function verify($id)
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getByID($this->endpointInstitution, $id.'?datatype=request', [], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        $data = $fetchData['data'];

        return view('admin.institution.verify', compact('data'));
    }

    public function verified(Request $request, $id)
    {
        $token = session('token.data.access_token');

        try {
            $verify = $this->admin->updateByID($this->endpointInstitution, $id, $request->all(), [
                'Authorization' => "Bearer " . $token
            ], 'verify');

            if ($verify['success'] == true) {
                session()->flash('success', $verify['message']);

                return redirect()->route('admin.data_kelembagaan.index');
            } else {
                session()->flash('error', $verify['message']);

                return redirect()->back();
            }
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());

            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $token = session('token.data.access_token');
        if (\Helper::isAsesi()) {
            $fetchData = $this->admin->getAll('admin/self/institution', [], [
                'Authorization' => "Bearer " . $token
            ]);
        } else {
            $fetchData = $this->admin->getById($this->endpointInstitution, $id, [], [
                'Authorization' => "Bearer " . $token
            ]);
        }

        $data = $fetchData['data'];

        return view('admin.institution.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $token = session('token.data.access_token');

        try {
            $user = $this->admin->storeInstitution('admin/self/institution', $data, [
                'Authorization' => "Bearer " . $token
            ]);

            if ($user['success'] == true) {
                session()->flash('success', $user['message']);

                return redirect()->route('admin.data_kelembagaan.index');
            } else {
                if (isset($user['code']) && $user['code'] == 'ERR4022') {
                    throw ValidationException::withMessages($user['errors']);
                }
                session()->flash('error', $user['message']);

                return redirect()->back();
            }
        } catch (ValidationException $e) {
            session()->flash('error', 'Gagal menyimpan data kelembagaan. Silakan periksa kembali.');
            throw $e;
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());

            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $token = session('token.data.access_token');

        try {
            $user = $this->admin->storeInstitution('admin/self/institution', $data, [
                'Authorization' => "Bearer " . $token
            ]);

            if ($user['success'] == true) {
                session()->flash('success', $user['message']);

                return redirect()->route('admin.data_kelembagaan.index');
            } else {
                if (isset($user['code']) && $user['code'] == 'ERR4022') {
                    throw ValidationException::withMessages($user['errors']);
                }

                session()->flash('error', $user['message']);

                return redirect()->back();
            }
        } catch (ValidationException $e) {
            session()->flash('error', 'Gagal menyimpan data kelembagaan. Silakan periksa kembali.');
            throw $e;
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());

            return redirect()->back();
        }
    }
}
