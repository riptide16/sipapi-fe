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
        if($data["certificate_file"]){
            $data["certificate_file"] = url("/storage_files/secure") . "/" . $data["certificate_file"];
        }

        if($data["recommendation_file"]){
            $data["recommendation_file"] = url("/storage_files/secure") . "/" . $data["recommendation_file"];
        }
        
        return view('admin.certifications.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $form = [];
        if ($request->hasFile('certificate_file')) {
            $extension = $request->file('certificate_file')->getClientOriginalExtension();
            $file = $request->file('certificate_file');
            $form[] = [
                'name' => 'certificate_file',
                'contents' => fopen($file, 'r'),
                'filename' => date('YmdHis') . '-' . $data['library_name'] . "." . $extension
            ];

            unset($data['certificate_file']);
        }

        if ($request->hasFile('recommendation_file')) {
            $extension = $request->file('recommendation_file')->getClientOriginalExtension();
            $file = $request->file('recommendation_file');
            $form[] = [
                'name' => 'recommendation_file',
                'contents' => fopen($file, 'r'),
                'filename' => date('YmdHis') . '-' . $data['library_name'] . "." . $extension
            ];

            unset($data['recommendation_file']);
        }

        if (empty($data['certificate_sent_at'])) {
            unset($data['certificate_sent_at']);
        }
        
        foreach ($data as $key => $formdata) {
            $form[] = [
                'name' => $key,
                'contents' => $formdata,
            ];
        }

        $form[] = [
            'name' => 'accreditation_id',
            'contents' => $id
        ];
        
        $token = session('token.data.access_token');

        try {
            $result = $this->admin->postFileUpload($this->endpoint, $form, [
                'Authorization' => "Bearer " . $token,
                'user-agent' => $request->server('HTTP_USER_AGENT'),
                'ip-address' => $request->ip()
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
