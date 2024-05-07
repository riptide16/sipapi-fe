<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SelfAssessmentController extends Controller
{
    public $endpoint;
    public $endpointInstrument;
    private $admin;

    public function __construct(AdminService $admin)
    {
        $this->endpoint = 'admin/accreditation_simulations';
        $this->admin = $admin;

        $this->endpointInstrument = 'admin/self/instrument';
    }

    public function create(Request $request)
    {
        $page = $request->page ?? 1;
        $type = $request->type;
        $token = session('token.data.access_token');

        try {
            $fetchData = $this->admin->getAll($this->endpointInstrument . "?type=choice&simulation=1&page=" . $page, [], [
                'Authorization' => "Bearer " . $token
            ]);
        } catch (HttpException $th) {
            if ($th->getStatusCode() == 403) {
                session()->flash('error', __('Mohon isi data kelembagaan terlebih dahulu.'));

                return redirect()->route('admin.data_kelembagaan.index');
            }
        }

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        return view('admin.self_assessment.create', compact('fetchData', 'type'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $dataStore = [];
        $extension = null;
        $output = [];

        if ($data['action_type'] == 'choice' && (!isset($data['statement']) || empty($data['statement']))) {
            session()->flash('error', 'Answer is required, please choose answer for continue.');

            return redirect()->back();
        }

        if ($data['action_type'] == "choice") {
            foreach ($data['aspect_id'] as $key => $aspectId) {
                if (isset($data['statement'][$aspectId])) {
                    $dataStore['contents'][$key]['type'] = $data['action_type'];
                    $dataStore['contents'][$key]['instrument_component_id'] = $data['component_id'][$key];
                    $dataStore['contents'][$key]['instrument_aspect_point_id'] = $data['statement'][$aspectId];
                    $dataStore['contents'][$key]['instrument_aspect_id'] = $aspectId;
                }
            }

            $dataStore['type'] = 'baru';
        }

        $token = session('token.data.access_token');
        $result = null;
        if ($data['action_type'] == 'choice') {
            $res = Http::acceptJson()->withToken($token)->asForm()
                ->post(config('services.api.url') . $this->endpoint, $dataStore);

            $result = $res->json();
        } else {
            $result = $this->admin->formData($this->endpoint, $output, [
                'Authorization' => "Bearer " . $token
            ]);
        }

        if ($result['success']) {
            if (!isset($data['next']) && empty($data['next'])) {
                return $this->finalize($result['data']['id']);
            } else {
                return redirect()->route('admin.self-assessment.create', ['type' => $data['type'], 'page' => $data['next']]);
            }
        } else {
            session()->flash('error', $result['message']);

            return redirect()->back();
        }
    }

    public function finalize($id)
    {
        $data = [
            'is_finalized' => true,
        ];

        $token = session('token.data.access_token');
        $result = $this->admin->createNew($this->endpoint . '/' . $id . '/' . 'finalize', $data, [
            'Authorization' => "Bearer " . $token
        ]);

        if ($result['success']) {
            return view('admin.self_assessment.result', compact('result'));
        } else {
            session()->flash('error', $result['message']);
            return redirect()->route('admin.self-assessment.create');
        }
    }
}
