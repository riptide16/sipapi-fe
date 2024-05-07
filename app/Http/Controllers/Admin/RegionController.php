<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RegionController extends Controller
{
    public $endpointProvince;
    public $endpointSubdistrict;
    public $endpointCity;
    public $endpointVillage;
    public $endpointRegion;
    public $endpointProvinceRegion;

    private $admin;
    public function __construct(AdminService $admin)
    {
        $this->admin = $admin;

        $this->endpointProvince = 'admin/provinces';
        $this->endpointCity = 'admin/cities';
        $this->endpointSubdistrict = 'admin/subdistricts';
        $this->endpointVillage = 'admin/villages';
        $this->endpointRegion = 'admin/regions';
        $this->endpointProvinceRegion = 'admin/province_region/provinces';
    }

    public function index(Request $request)
    {
        $regions = [
            'regions' => 'Wilayah',
            'provinces' => 'Provinsi',
            'cities' => 'Kota/Kabupaten',
            'subdistricts' => 'Kecamatan',
            'villages' => 'Kelurahan',
        ];

        $masterData = [
            'regions' => [],
            'provinces' => [],
            'cities' => [],
            'subdistricts' => [],
            'villages' => [],
        ];

        return view('admin.region.index', compact('regions', 'masterData'));
    }

    public function getLocation(Request $request)
    {
        $token = session('token.data.access_token');
        $province = (isset($request->province_id)) ? $request->province_id : false;
        $city = (isset($request->city_id)) ? $request->city_id : false;
        $subdistrict = (isset($request->subdistrict_id)) ? $request->subdistrict_id : false;
        $region = (isset($request->region_id)) ? $request->region_id : false;

        if ($subdistrict) {
            $body = [
                'subdistrict_id' => $subdistrict,
                'per_page' => -1
            ];

            $endpoint = 'admin/self/villages';
        } elseif ($city) {
            $body = [
                'city_id' => $city,
                'per_page' => -1
            ];

            $endpoint = 'admin/self/subdistricts';
        } elseif ($province) {
            $body = [
                'province_id' => $province,
                'per_page' => -1
            ];

            $endpoint = 'admin/self/cities';
        } elseif ($region) {
            $body = [
                'regions:id' => $region,
                'per_page' => -1
            ];

            $endpoint = 'admin/self/provinces';
        }

        $get = $this->admin->getAll($endpoint, $body, [
            'Authorization' => 'Bearer ' . $token
        ]);

        return response()->json($get);
    }
}
