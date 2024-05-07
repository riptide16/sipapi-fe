<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdminService;

class DashboardController extends Controller
{
    public $endpoint;
    public $endpointChart;
    private $admin;

    public function __construct(AdminService $admin)
    {
        $this->admin = $admin;
        $this->endpoint = 'admin/self/notifications';
        $this->endpointChart = 'admin/self/dashboard';
    }

    public function index()
    {
        $token = session('token.data.access_token');
        $notifAll = $this->admin->getAll($this->endpoint.'/all', [], [
            'Authorization' => "Bearer " . $token
        ]);
        $notif = $this->admin->getAll($this->endpoint, [], [
            'Authorization' => "Bearer " . $token
        ]);

        $fetchData = $this->admin->getAll($this->endpointChart, [], [
            'Authorization' => "Bearer " . $token
        ]);

        $latesAcreditation = $fetchData['data']['latest_accreditations'] ?? [];

        $submittedAccreditations = [];
        if (\Helper::isAsesi()) {
            $submittedAccreditations = $fetchData['data']['submitted_accreditations'];
        } elseif (\Helper::isAsesor()) {
            $submittedAccreditations = $fetchData['data']['evaluation_schedule'];
        }

        $notification = session(['allNotifications' => $notifAll,'notifications' => $notif]);

        return view('admin.dashboard', compact('latesAcreditation', 'submittedAccreditations'));
    }

    public function getDataChart()
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getAll($this->endpointChart, [], [
            'Authorization' => "Bearer " . $token
        ]);

        $items = [];

        $categories = [];
        $index = 0;
        foreach ($fetchData['data']['categories'] as $key => $category) {
            $categories[$index]['x'] = $key;
            $categories[$index]['y'] = $category;

            $index++;
        }

        $statuses = [];
        $index2 = 0;
        foreach ($fetchData['data']['statuses'] as $key => $status) {
            $statuses[$index2]['x'] = $key;
            $statuses[$index2]['y'] = $status;

            $index2++;
        }

        $index3 = 0;
        $predicates = [];
        $labels = [];
        foreach ($fetchData['data']['predicates'] as $key => $predicate) {
            $predicates[] = (int)$predicate;
            $labels[] = $key;

            $index3++;
        }

        $items['categories'] = $categories ?? [];
        $items['statuses'] = $statuses ?? [];
        $items['predicates'] = $predicates ?? [];
        $items['labels'] = $labels ?? [];
        $items['total_accreditations'] = $fetchData['data']['total_accreditations'] ?? 0;
        return response()->json($items);
    }

    public function getDataAsesi()
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getAll($this->endpointChart, [], [
            'Authorization' => "Bearer " . $token
        ]);
        $items = [];

        $perPeriods = [];
        $index4 = 0;
        foreach ($fetchData['data']['per_period'] as $key => $period) {
            $perPeriods[$index4]['x'] = $period['period'];
            $perPeriods[$index4]['y'] = $period['total'];

            $index4++;
        }

        $items['perPeriods'] = $perPeriods ?? [];
        $items['totalPeriod'] = $fetchData['data']['total'] ?? 0;
        return response()->json($items);
    }

    public function getDataAsesor()
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getAll($this->endpointChart, [], [
            'Authorization' => "Bearer " . $token
        ]);
        $items = [];

        $items['totalPeriod'] = $fetchData['data']['total'] ?? 0;
        return response()->json($items);
    }
}
