<?php

namespace App\Http\Controllers;

use App\Services\AdminService;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    private $admin;

    public function __construct(AdminService $admin)
    {
        $this->endpoint = config('services.api.domain').'storage/';
        $this->secureEndpoint = 'storage_files/';
        $this->admin = $admin;
    }

    public function showFile(Request $request, $path)
    {
        $file = $this->admin->downloadFile($this->endpoint.$path);

        if ($this->admin->getResponse()->getStatusCode() !== 200) {
            abort($this->admin->getResponse()->getStatusCode());
        }

        $method = $request->has('stream') ? 'stream' : 'download';
        return $this->{$method}($path, $file);
    }

    public function showSecureFile(Request $request, $path)
    {
        $token = session('token.data.access_token');
        $file = $this->admin->downloadFile($this->secureEndpoint.$path, [
            'Authorization' => "Bearer " . $token
        ]);

        if ($this->admin->getResponse()->getStatusCode() !== 200) {
            abort($this->admin->getResponse()->getStatusCode());
        }

        $method = $request->has('stream') ? 'stream' : 'download';
        return $this->{$method}($path, $file);
    }

    protected function download($path, $content)
    {
        if (isset($this->admin->getResponse()->getHeaders()['Filename'])) {
            $filename = $this->admin->getResponse()->getHeaders()['Filename'][0];
        } else {
            $filename = ($ex = explode('/', $path))[count($ex)-1];
        }
        $path = storage_path($filename);
        file_put_contents($path, $content);

        return response()->download($path)->deleteFileAfterSend(true);
    }

    protected function stream($path, $content)
    {
        $filename = ($ex = explode('/', $path))[count($ex)-1];
        $path = storage_path($filename);
        file_put_contents($path, $content);
        $mime = mime_content_type($path);
        unlink($path);

        return response()->make($content)->header('Content-Type', $mime);
    }
}
