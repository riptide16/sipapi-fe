<?php

namespace App\Http\Controllers\Admin;

use App\Services\AdminService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    public $endpoint;
    private $admin;

    public function __construct(AdminService $admin)
    {
        $this->endpoint = 'admin/certifications';
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
        
        $index = 0;

        foreach($fetchData["data"] as $row){
            if($row["certificate_file"]){
                $fetchData["data"][$index]["certificate_file"] = url("/storage_files/secure") . "/" . $row["certificate_file"];
            }
    
            if($row["recommendation_file"]){
                $fetchData["data"][$index]["recommendation_file"] = url("/storage_files/secure") . "/" . $row["recommendation_file"];
            }
            $index++;
        }

        return view('admin.certifications.index', compact('fetchData'));
    }

    public function edit($id)
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getById($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token
        ]);

        $data = $fetchData['data'];

        return view('admin.certifications.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        if (empty($data['certificate_sent_at'])) {
            unset($data['certificate_sent_at']);
        }

        $token = session('token.data.access_token');

        try {
            $result = $this->admin->put($this->endpoint, $id, $data, [
                'Authorization' => "Bearer " . $token
            ]);

            if ($result['success'] === true) {
                session()->flash('success', $result['message']);

                return redirect()->route('admin.sertifikasi.show', [$id]);
            } else {
                session()->flash('error', $result['message']);

                return redirect()->back();
            }
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());

            return redirect()->back();
        }
    }
}
