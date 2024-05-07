<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdminService;

class NotificationController extends Controller
{
    public $endpoint;
    public $endpointAccreditation;
    private $admin;

    public function __construct(AdminService $admin)
    {
        $this->admin = $admin;
        $this->endpoint = 'admin/self/notifications';
        $this->endpointAccreditation = 'admin/accreditations/update/status';
    }

    public function index()
    {
        $token = session('token.data.access_token');
        $notifAll = $this->admin->getAll($this->endpoint.'/all', ['show_all' => true], [
            'Authorization' => "Bearer " . $token
        ]);
        $notif = $this->admin->getAll($this->endpoint, [], [
            'Authorization' => "Bearer " . $token
        ]);

        $notification = session(['allNotifications' => $notifAll,'notifications' => $notif]);

        return view('admin.notification');
    }

    public function show($id)
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getByID($this->endpoint, $id, [], [
            'Authorization' => "Bearer " . $token
        ]);

        $notifAll = $this->admin->getAll($this->endpoint.'/all', [], [
            'Authorization' => "Bearer " . $token
        ]);
        $notif = $this->admin->getAll($this->endpoint, [], [
            'Authorization' => "Bearer " . $token
        ]);

        $notification = session(['allNotifications' => $notifAll,'notifications' => $notif]);

        return view('admin.notification-read', compact('fetchData'));
    }

    public function update(Request $request, $id)
    {
        $token = session('token.data.access_token');
        $accreditation = $this->admin->getAll($this->endpointAccreditation.'/'.$id.'?status='.$request->status, [], [
            'Authorization' => "Bearer " . $token
        ]);

        return redirect(route('admin.akreditasi.show', ['akreditasi' => $id]));
    }
}
