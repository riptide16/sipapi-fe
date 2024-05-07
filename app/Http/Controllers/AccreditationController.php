<?php

namespace App\Http\Controllers;

use Cache;
use Illuminate\Http\Request;
use App\Services\AdminService;

class AccreditationController extends Controller
{
    public function __construct(AdminService $admin)
    {
        $this->endpoint = 'accreditations';
        $this->admin = $admin;
    }

    public function browse(Request $request)
    {
        $request->validate([
            'captcha' => 'required_if:do,1|captcha',
        ], [
            'captcha.required_if' => 'Harap mengisi captcha',
        ]);

        $libraries = [];
        $get = $request->except('captcha');
        if (!$request->get('do')) {
            $get = [];
        }

        if (!empty($get)) {
            $libraries = $this->admin->getAll(
                $this->endpoint, array_merge($get, [
                    'per_page' => 10,
                    'page' => $request->page
                ]),
                []
            );
        }

        $provinces = Cache::remember('province_list', 60, function () {
            return $this->admin->getAll(
                'provinces', ['per_page' => -1],
                []
            );
        })['data'] ?? [];
        $predicates = ['A', 'B', 'C'];
        $categories = [
            'Perpustakaan Desa',
            'Kecamatan',
            'Kabupaten Kota',
            'Provinsi',
            'SD MI',
            'SMP MTs',
            'SMA SMK MA',
            'Perguruan Tinggi',
            'Khusus',
        ];

        return view(
            'public.layanan.akreditasi.browse',
            compact('provinces', 'predicates', 'categories', 'libraries', 'get')
        );
    }

    public function totalByCategory()
    {
        $totals = Cache::remember('total_accreditation_by_category', 60, function () {
            return $this->admin->getAll('accreditations/total_by_category');
        });

        return view(
            'public.tentang-kami.total-akreditasi-by-category',
            compact('totals')
        );
    }

    public function getCities(Request $request)
    {
        $body = [
            'province_id' => $request->get('province_id'),
            'per_page' => -1
        ];

        $endpoint = 'cities';

        $get = $this->admin->getAll($endpoint, $body);

        return response()->json($get);
    }
}
