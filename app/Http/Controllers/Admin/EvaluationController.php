<?php

namespace App\Http\Controllers\Admin;

use App\Services\AdminService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EvaluationController extends Controller
{
    public $endpoint;
    private $admin;

    public function __construct(AdminService $admin)
    {
        $this->endpoint = 'admin/evaluations';
        $this->endpointAccreditation = 'admin/accreditations';
        $this->secureEndpoint = 'storage_files';
        $this->admin = $admin;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getAll($this->endpoint, ['per_page' => -1], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        return view('admin.evaluations.index', compact('fetchData'));
    }

    public function show($id, Request $request)
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getByID($this->endpointAccreditation, $id.'/instruments', [
            'page' => $request->page ?? 1,
            'type' => 'choice',
        ], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        $assignment = session('token.assignment_'.$id);

        if (!$assignment) {
            $assignments = $this->admin->getById($this->endpointAccreditation, $id."/evaluation_assignments", [], [
                'Authorization' => "Bearer " . $token
            ]);
            
            if (!empty($assignments['data'])) {
                $assignment = $assignments['data'][0];
                session(['token.assignment_'.$id => $assignment]);
            }
        }

        $setFetchDataEvaluation = session(['getFetchDataEvaluation' => $fetchData]);

	    $accreditation = $this->admin->getByID($this->endpointAccreditation, $id, [], [
            'Authorization' => "Bearer " . $token
        ]);

        $result = $accreditation['data'];
        usort($result['results'], fn($a, $b) => $a['instrument_component_id'] <=> $b['instrument_component_id']);

        $finalResult = $accreditation['data']['finalResult']['score'];

        $setFetchDataEvaluation = session(['getFetchDataEvaluation' => $fetchData]);

        return view('admin.evaluations.show', compact('fetchData', 'id', 'assignment','finalResult','result'));
    }

    public function evaluate($id, Request $request)
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getByID($this->endpointAccreditation, $id.'/instruments', [
            'page' => $request->page ?? 1,
            'type' => 'choice',
        ], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        return view('admin.evaluations.evaluate', compact('fetchData', 'id'));
    }

    public function save($id, Request $request)
    {
        if ($request->get('action_type') == 'choice' && $request->has('aspects')) {
            $param = [
                'accreditation_id' => $id,
                'contents' => [],
            ];
            $evaluations = $request->get('evaluations');
            $contents = $request->get('contents');
            foreach ($request->get('aspects') as $aspect) {
                if (isset($contents[$aspect])) {
                    $param['contents'][] = [
                        'instrument_aspect_point_id' => $evaluations[$aspect],
                        'accreditation_content_id' => $contents[$aspect],
                    ];
                }
            }
            $param['is_complete'] = !$request->has('next');

            $token = session('token.data.access_token');
            $fetchData = $this->admin->createNew($this->endpoint, $param, [
                'Authorization' => "Bearer " . $token
            ]);

            if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
                return redirect()->route('logout');
            }
        }

        if (!$request->has('next')) {
            return redirect()->route('admin.penilaian.results', ['id' => $id]);
        }
        return redirect()->route('admin.penilaian.evaluate', ['penilaian' => $id, 'page' => $request->get('next')]);
    }

    public function results($id)
    {
        $token = session('token.data.access_token');
        $result = $this->admin->getByID($this->endpointAccreditation, $id, [], [
            'Authorization' => "Bearer " . $token
        ]);
        if (isset($result['code']) && $result['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        if (!isset($result['data']['evaluation'])) {
            return abort(404);
        }

        $assignments = $this->admin->getById($this->endpointAccreditation, $id."/evaluation_assignments", [], [
            'Authorization' => "Bearer " . $token
        ]);
        if (empty($assignments['data'])) {
            return abort(404);
        }

        $result = $result['data'];
        $assignment = $assignments['data'][0];

        return view('admin.evaluations.result', compact('result', 'assignment', 'id'));
    }

    public function finalize(Request $request, $id)
    {
        $data = $request->all();

        $form = [];
        $index = 0;
        foreach ($data['recommendations'] as $componentId => $rec) {
            $form[] = [
                'name' => "recommendations[{$index}][instrument_component_id]",
                'contents' => $componentId,
            ];
            $form[] = [
                'name' => "recommendations[{$index}][content]",
                'contents' => $rec,
            ];
            $index++;
        }

        $token = session('token.data.access_token');
        $result = $this->admin->formData($this->endpoint . '/' . $id . '/' . 'document_file', $form, [
            'Authorization' => "Bearer " . $token
        ]);
        if ($result['success']) {
            $download = $this->admin->getById($this->endpoint, $id."/download_document", [], [
                'Authorization' => "Bearer " . $token
            ]);

            $path = '/evaluations/berita-acara/'.$id.'.pdf';
            $file = $this->admin->downloadFile($this->secureEndpoint.$path);

            $filename = ($ex = explode('/', $path))[count($ex)-1];
            $publicPath = storage_path('app/public/'.$filename);
            file_put_contents($publicPath, $file);

            session()->flash('success', 'Sukses menyimpan data');

            return response()->download($publicPath)->deleteFileAfterSend(true);
        } else {
            session()->flash('error', $result['message']);
            return redirect()->back()->withInput();
        }
    }

    public function uploadDocument(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|file|max:2048|mimes:doc,docx,pdf',
        ]);
        $data = $request->all();

        $form = [];
        $extension = $request->file('file')->getClientOriginalExtension();
        $form[] = [
            'name' => 'file',
            'contents' => fopen($data['file'], 'r'),
            'filename' => date('YmdHis') . '-penilaian.' . $extension
        ];

        $token = session('token.data.access_token');
        $result = $this->admin->formData($this->endpoint . '/' . $id . '/' . 'document_file', $form, [
            'Authorization' => "Bearer " . $token
        ]);
        if ($result['success']) {
            session()->flash('success', 'Sukses mengunggah data');
            return redirect()->route('admin.penilaian.recap', [$result['data']['accreditation_id']]);
        } else {
            session()->flash('error', $result['message']);
            return redirect()->back()->withInput();
        }
    }

    public function recap($id)
    {
        $token = session('token.data.access_token');
        $result = $this->admin->getByID($this->endpointAccreditation, $id, [], [
            'Authorization' => "Bearer " . $token
        ]);
        if (isset($result['code']) && $result['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        if (!isset($result['data']['evaluation'])) {
            session()->flash('error', __('Data rekap belum tersedia, silakan lengkapi proses penilaian terlebih dahulu.'));
            return redirect()->route('admin.akreditasi.show', [$id]);
        }

        $assignments = $this->admin->getById($this->endpointAccreditation, $id."/evaluation_assignments", [], [
            'Authorization' => "Bearer " . $token
        ]);
        if (empty($assignments['data'])) {
            session()->flash('error', __('Data rekap belum tersedia, silakan lengkapi proses penilaian terlebih dahulu.'));
            return redirect()->route('admin.akreditasi.show', [$id]);
        }

        $result = $result['data'];
        $assignment = $assignments['data'][0];

        return view('admin.evaluations.recap', compact('result', 'assignment', 'id'));
    }

    public function downloadFile($id)
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getByID($this->endpointAccreditation, $id, [
            'page' => -1,
            'type' => 'proof'
        ], [
            'Authorization' => "Bearer " . $token
        ], 'instruments');

        $fetchDataVideo = $this->admin->getByID($this->endpointAccreditation, $id, [
            'page' => 1,
            'type' => 'video'
        ], [
            'Authorization' => "Bearer " . $token
        ], 'instruments');

        $fetchDataGdrive = $this->admin->getByID($this->endpointAccreditation, $id, [
            'page' => 1,
            'type' => 'gdrive'
        ], [
            'Authorization' => "Bearer " . $token
        ], 'instruments');

        return view('admin.evaluations.download-file', compact('id', 'fetchData', 'fetchDataVideo', 'fetchDataGdrive'));
    }
}
