<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AccreditationController extends Controller
{
    public $endpoint;
    public $endpointInstrument;
    public $endpointCountInstrument;
    private $admin;
    public function __construct(AdminService $admin)
    {
        $this->endpoint = 'admin/accreditations';
        $this->admin = $admin;

        $this->endpointInstrument = 'admin/self/instrument';
        $this->endpointCountInstrument = 'admin/instrument';
    }

    public function index(Request $request)
    {   
        try {
            $token = session('token.data.access_token');
            $fetchData = $this->admin->getAll($this->endpoint, ['per_page' => -1], [
                'Authorization' => "Bearer " . $token,
                'user-agent' => $request->server('HTTP_USER_AGENT'),
                'ip-address' => $request->ip()
            ]);

            if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
                return redirect()->route('logout');
            }
            return view('admin.accreditation.index', compact('fetchData'));
        } catch (HttpException $th) {
            if ($th->getStatusCode() == 403) {
                session()->flash('error', __('Mohon isi data kelembagaan terlebih dahulu.'));

                return redirect()->route('admin.data_kelembagaan.index');
            }
        }
    }

    public function show($id, Request $request)
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getByID($this->endpoint, $id . '/' . 'instruments', [
            'page' => $request->page ?? 1,
            'type' => 'choice',
        ], [
            'Authorization' => "Bearer " . $token
        ]);

        $fetchDataVideo = $this->admin->getByID($this->endpoint, $id . '/' . 'instruments', [
            'page' => $request->page ?? 1,
            'type' => 'video',
        ], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

	$accreditationData = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token
        ]);

        $result = $accreditationData['data'];
        usort($result['results'], fn($a, $b) => $a['instrument_component_id'] <=> $b['instrument_component_id']);
        $finalResult = $accreditationData['data']['finalResult']['score'];


        $status = $request->status ?? null;
        $accreditation = $fetchData['data'][0]['accreditation'] ?? null;
        $setFetchDataAccreditation = session(['getFetchDataAccreditation' => $fetchData]);

        return view('admin.accreditation.show', compact('fetchData', 'id', 'status', 'accreditation', 'fetchDataVideo','finalResult','result'));
    }

    public function create(Request $request)
    {
        $page = $request->page ?? 1;
        $type = $request->type;
        $token = session('token.data.access_token');

        $fetchData = $this->admin->getAll($this->endpointInstrument . "?page=" . $page, [], [
            'Authorization' => "Bearer " . $token
        ]);
        
        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }
        
        return view('admin.accreditation.create', compact('fetchData', 'type'));
    }

    public function edit(Request $request, $id)
    {
        return $this->create($request);
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

            $dataStore['type'] = $data['type'];
        } elseif ($data['action_type'] == "proof") {
            if (!$request->hasFile('file_upload')) {
                if (!isset($data['next']) && empty($data['next'])) {
                    $accreditation = $this->getIncompleteAccreditation();
                    return $this->finalize($accreditation['id']);
                } else { 
                    return redirect()->route('admin.akreditasi.create', ['type' => $data['type'], 'page' => $data['next']]);
                }
            }

            $extension = $request->file('file_upload')->getClientOriginalExtension();
            $output[] = [
                'name' => 'contents[0][file_upload]',
                'contents' => fopen($data['file_upload'], 'r'),
                'filename' => date('YmdHis') . '-akreditasi.' . $extension
            ];

            $output[] = [
                'name' => 'contents[0][type]',
                'contents' => $data['action_type'],
            ];

            $output[] = [
                'name' => 'contents[0][instrument_component_id]',
                'contents' => $data['component_id'],
            ];

            $output[] = [
                'name' => 'type',
                'contents' => $data['type'],
            ];
        } else {
            $dataStore['contents'][0]['type'] = $data['action_type'];
            $dataStore['contents'][0]['instrument_component_id'] = $data['component_id'];
            $dataStore['contents'][0]['url'] = $data['url'];
            $dataStore['type'] = $data['type'];
        }

        $token = session('token.data.access_token');
        $result = null;
        if ($data['action_type'] == 'choice') {
            $res = Http::acceptJson()->withToken($token)->asForm()
                ->post(config('services.api.url') . $this->endpoint, $dataStore);

            $result = $res->json();
        } elseif ($data['action_type'] == 'proof') {
            $result = $this->admin->formData($this->endpoint, $output, [
                'Authorization' => "Bearer " . $token
            ]);
        } else {
            $res = Http::acceptJson()->withToken($token)->asForm()
                ->post(config('services.api.url') . $this->endpoint, $dataStore);

            $result = $res->json();
        }

        if ($result['success']) {
            if (!isset($data['next']) && empty($data['next'])) {
                return $this->finalize($result['data']['id']);
            } else {
                return redirect()->route('admin.akreditasi.create', ['type' => $data['type'], 'page' => $data['next']]);
            }
        } else {
            session()->flash('error', $result['message']);

            return redirect()->back();
        }
    }

    public function getIncompleteAccreditation()
    {
        $token = session('token.data.access_token');
        $result = $this->admin->getAll('admin/self/accreditations/incomplete', [], [
            'Authorization' => "Bearer " . $token
        ]);
        if ($result['success'] === true && !empty($result['data'])) {
            return $result['data'];
        }

        return null;
    }

    public function results($id)
    {
        $token = session('token.data.access_token');
        $result = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token
        ]);

        return view('admin.accreditation.result', compact('result'));
    }

    public function finalize($id)
    {

        $token = session('token.data.access_token');

        //  Jumlah isian Instrumen yang sudah dijawab Asesi
	    $accreditationData = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token
        ]);


        // Menghitung Jumlah isian Instrumen sama dengan jumlah IK Instrumen atau tidak
        $category = $accreditationData["data"]["institution"]["category"];
        
        $countInstrument = $this->admin->getByID($this->endpointCountInstrument, $category, [], [
            'Authorization' => "Bearer " . $token
        ]);
        
        if ($accreditationData['data']['finalResult']['total_instrument'] != $countInstrument) {
            session()->flash('error', 'Mohon maaf isian Instrumen belum lengkap. Silahkan Cek Kembali.');

            return redirect()->back();
        }

        $data = [
            'is_finalized' => true,
        ];

        $result = $this->admin->createNew($this->endpoint . '/' . $id . '/' . 'finalize', $data, [
            'Authorization' => "Bearer " . $token
        ]);

        if ($result['success']) {
            session()->flash('success', 'Pengajuan akreditasi Anda berhasil dikirim');
            return redirect()->route('admin.akreditasi.index');
        } else {
            session()->flash('error', $result['message']);
            return redirect()->back();
        }
    }

    public function verify(Request $request, $id)
    {
        $token = session('token.data.access_token');
        $param = http_build_query([
            'with' => 'evaluationAssignments.assessors',
        ]);
        $fetchData = $this->admin->getByID($this->endpoint, $id.'?'.$param, [], [
            'Authorization' => "Bearer " . $token
        ]);
        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }
        

        $fetchData = $fetchData['data'];
        if ($fetchData['status'] == 'belum_lengkap') {
            abort(404);
        }
        
        $readOnly = $fetchData['status'] != 'diajukan';
        
        return view('admin.accreditation.verify', compact('fetchData', 'readOnly'));
    }

    public function postVerify(Request $request, $id)
    {
        $data = $request->except('_token');
        $data['is_approved'] = (bool) $data['is_approved'];

        if ($data['is_approved']) {
            $storeAsesor = [];
            foreach (range(1, 3) as $no) {
                if (!empty($data['asesor_'.$no])) {
                    $storeAsesor[] = [
                        'user_id' => $data['asesor_'.$no]
                    ];
                }
            }
            $data = array_merge($data, [
                'assessors' => $storeAsesor,
                'scheduled_date' => $data['scheduled_date'],
                'method' => $data['method']
            ]);
        }

        $token = session('token.data.access_token');
        $fetchData = $this->admin->createNew("{$this->endpoint}/{$id}/verify", $data, [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        if ($fetchData['success'] == true) {
            session()->flash('success', 'Berhasil verifikasi');

            return redirect()->route('admin.akreditasi.index');
        } else {
            session()->flash('error', $fetchData['message']);

            return redirect()->back();
        }
    }

    public function process($id)
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token
        ]);
        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        $fetchData = $fetchData['data'];
        if (empty($fetchData['evaluation'])) {
            session()->flash('error', __('Data proses belum tersedia, silakan lengkapi proses penilaian terlebih dahulu.'));
            return redirect()->route('admin.akreditasi.show', [$id]);
        }
        return view('admin.accreditation.process', compact('fetchData'));
    }

    public function postProcess(Request $request, $id)
    {
        $data = $request->only(['predicate', 'meeting_date']);

        $token = session('token.data.access_token');
        $fetchData = $this->admin->createNew("{$this->endpoint}/{$id}/process", $data, [
            'Authorization' => "Bearer " . $token
        ]);
        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        if ($fetchData['success'] == true) {
            session()->flash('success', 'Berhasil proses');

            return redirect()->route('admin.akreditasi.index');
        } else {
            session()->flash('error', $fetchData['message']);

            return redirect()->back();
        }
    }

    public function downloadFile($id)
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getByID($this->endpoint, $id, [
            'page' => -1,
            'type' => 'proof'
        ], [
            'Authorization' => "Bearer " . $token
        ], 'instruments');

        $fetchDataVideo = $this->admin->getByID($this->endpoint, $id, [
            'page' => 1,
            'type' => 'video'
        ], [
            'Authorization' => "Bearer " . $token
        ], 'instruments');

        $fetchDataGdrive = $this->admin->getByID($this->endpoint, $id, [
            'page' => 1,
            'type' => 'gdrive'
        ], [
            'Authorization' => "Bearer " . $token
        ], 'instruments');


        return view('admin.accreditation.download-file', compact('fetchData', 'fetchDataVideo','fetchDataGdrive'));
    }

    public function accept(Request $request, $id)
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token,
            'user-agent' => $request->server('HTTP_USER_AGENT'),
            'ip-address' => $request->ip()
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        return view('admin.accreditation.accept', compact('fetchData', 'id'));
    }

    public function acceptProcess(Request $request, $id)
    {
        $data = $request->all();

        $isAccepted = false;
        if ($data['accept'] == "1") {
            $isAccepted = true;
        } else {
            $isAccepted = false;
        }

        $token = session('token.data.access_token');
        $fetchData = $this->admin->createNew(
            $this->endpoint . '/' . $id . '/accept',
            [
                "is_accepted" => $isAccepted
            ],
            [
                'Authorization' => "Bearer " . $token,
                'user-agent' => $request->server('HTTP_USER_AGENT'),
                'ip-address' => $request->ip()
            ]
        );

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        if ($fetchData['success'] == true) {
            if (!$isAccepted) {
                session()->flash('success', 'Berhasil mengajukan banding');
                return redirect()->route('admin.akreditasi.edit', [
                    'akreditasi' => $fetchData['data']['id'],
                    'type' => 'banding',
                ]);
            }

            session()->flash('success', 'Berhasil proses');
            return redirect()->route('admin.akreditasi.show', [$id]);
        } else {
            session()->flash('error', $fetchData['message']);

            return redirect()->back();
        }
    }
}
