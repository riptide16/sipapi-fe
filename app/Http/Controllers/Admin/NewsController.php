<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\News\CreateRequest;
use App\Http\Requests\Admin\News\UpdateRequest;
use App\Services\AdminService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public $endpoint;
    private $admin;

    public function __construct(AdminService $admin)
    {
        $this->admin = $admin;
        $this->endpoint = 'admin/news';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $token = session('token.data.access_token');
        $fetchDataNews = $this->admin->getAll($this->endpoint, [], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchDataNews['code']) && $fetchDataNews['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        return view('admin.news.index', compact('fetchDataNews'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $data = $request->all();

        $token = session('token.data.access_token');
        $output = [];
        $output[] = [
            'name' => 'title',
            'contents' => $data['title']
        ];

        $output[] = [
            'name' => 'body',
            'contents' => $data['body']
        ];

        $output[] = [
            'name' => 'published_date',
            'contents' => Carbon::parse($data['published_date'])->format('Y-m-d H:i:s')
        ];

        $output[] = [
            'name' => 'image_file',
            'contents' => fopen($data['image_file'], 'r'),
            'filename' => 'news_' . date('YmdHis') . '.png'
        ];

        $news = $this->admin->formData($this->endpoint, $output, [
            'Authorization' => "Bearer " . $token
        ]);

        if ($news['success']) {
            session()->flash('success', $news['message']);

            return redirect()->route('admin.berita.index');
        } else {
            session()->flash('error', $news['message']);

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $token = session('token.data.access_token');
        $fetchDataNews = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchDataNews['code']) && $fetchDataNews['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        $news = $fetchDataNews['data'];

        return view('admin.news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $token = session('token.data.access_token');
        $fetchDataNews = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchDataNews['code']) && $fetchDataNews['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        $news = $fetchDataNews['data'];
        $publishedDate = Carbon::parse($news['published_date'])->toDateTimeLocalString();

        return view('admin.news.edit', compact('news', 'publishedDate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $data = $request->all();

        $token = session('token.data.access_token');
        $output = [];
        $output[] = [
            'name' => 'title',
            'contents' => $data['title']
        ];

        $output[] = [
            'name' => 'body',
            'contents' => $data['body']
        ];

        $output[] = [
            'name' => 'published_date',
            'contents' => Carbon::parse($data['published_date'])->format('Y-m-d H:i:s')
        ];

        $output[] = [
            'name' => '_method',
            'contents' => 'PUT'
        ];

        if (isset($data['image_file'])) {
            $output[] = [
                'name' => 'image_file',
                'contents' => fopen($data['image_file'], 'r'),
                'filename' => 'news_' . date('YmdHis') . '.png'
            ];
        }

        $news = $this->admin->formData($this->endpoint . '/' . $id, $output, [
            'Authorization' => "Bearer " . $token
        ]);


        if ($news['success']) {
            session()->flash('success', $news['message']);

            return redirect()->route('admin.berita.index');
        } else {
            session()->flash('error', $news['message']);

            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $token = session('token.data.access_token');
        $deleteNews = $this->admin->deleteByID($this->endpoint, $id, [
            'Authorization' => "Bearer " . $token
        ]);

        if ($deleteNews['success']) {
            return response()->json([
                'status' => 'success',
                'message' => $deleteNews['message']
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => $deleteNews['message']
            ]);
        }
    }
}
