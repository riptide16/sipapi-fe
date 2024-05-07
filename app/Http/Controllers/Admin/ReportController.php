<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public $endpoint;
    private $admin;

    public function __construct(AdminService $admin)
    {
        $this->endpoint = 'admin/reports';
        $this->admin = $admin;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.report.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function reportDetailTerakreditasiByProvinceInYear(Request $request)
    {
        if ($request->get('export')) {
            $today = now()->format('Ymd');
            return $this->export($this->endpoint . '/total_accredited_libraries_by_provinces_in_year', $today . ' - Report Detail Terakreditasi Berdasarkan Provinsi Dalam Tahun.xlsx');
        }

        $token = session('token.data.access_token');
        $fetchData = $this->admin->getAll($this->endpoint . '/total_accredited_libraries_by_provinces_in_year', ['province' => $request->province], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        $years = [];
        foreach ($fetchData['data']['detail'] as $key => $value) {
            foreach ($value as $key2 => $value2) {
                if ($key2 != 'name') {
                    $years[] = $key2;
                }
            }
        }

        $province = $request->province;
        $years = array_unique($years);

        return view('admin.report.provinsi.terakreditasi.show', compact('years', 'fetchData', 'province'));
    }

    public function reportTerakreditasiByProvinsiPerYear(Request $request)
    {
        $year = $request->year ?? date('Y');
        if ($request->get('export')) {
            $today = now()->format('Ymd');
            return $this->export($this->endpoint . '/total_accredited_libraries_by_provinces_per_year?year=' . $year, $today . ' - Report Jumlah Akreditasi Berdasarkan Provinsi Per Tahun.xlsx');
        }

        $token = session('token.data.access_token');
        $fetchData = $this->admin->getAll($this->endpoint . '/total_accredited_libraries_by_provinces_per_year', ['year' => $year], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        return view('admin.report.provinsi.terakreditasi.index-by-year', compact('year', 'fetchData'));
    }

    public function reportTerakreditasiByLibraryTypePerYear(Request $request)
    {
        $year = $request->year ?? date('Y');
        if ($request->get('export')) {
            $today = now()->format('Ymd');
            return $this->export($this->endpoint . '/total_accredited_libraries_per_year?year=' . $year, $today . ' - Report Jumlah Akreditasi Berdasarkan Jenis Perpustakaan Pertahun.xlsx');
        }

        $token = session('token.data.access_token');
        $fetchData = $this->admin->getAll($this->endpoint . '/total_accredited_libraries_per_year', ['year' => $year], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        return view('admin.report.library-type.terakreditasi.index-by-year', compact('year', 'fetchData'));
    }

    public function totalReport(Request $request)
    {
        if ($request->get('export')) {
            $today = now()->format('Ymd');
            return $this->export($this->endpoint . '/total_accreditations', $today . ' - Report Jumlah Akreditasi.xlsx');
        }

        $token = session('token.data.access_token');
        $fetchData = $this->admin->getAll($this->endpoint . '/total_accreditations', [], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        return view('admin.report.total', compact('fetchData'));
    }

    public function reportLibraryTypeInYear(Request $request)
    {
        if ($request->get('export')) {
            $today = now()->format('Ymd');
            return $this->export($this->endpoint . '/total_accreditations_per_year', $today . ' - Report Jumlah Akreditasi Berdasarkan Jenis Perpustakaan Dalam Tahun.xlsx');
        }

        $token = session('token.data.access_token');
        $fetchData = $this->admin->getAll($this->endpoint . '/total_accreditations_per_year', ['per_page' => -1], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        $dataResponse = [];
        $years = [];
        $index = 0;
        foreach ($fetchData['data']['per_year'] as $key => $value) {
            $dataResponse[$index] = $key;
            if (count($value) > 0) {
                foreach ($value as $key2 => $value2) {
                    if ($key2 != "total") {
                        $years[$index] = "$key2";
                    }
                }
            } else {
                $years[$index] = Carbon::now()->format('Y');
            }

            $index++;
        }
        $resultYears = array_unique($years);

        return view('admin.report.library-type.in-year.index', compact('fetchData', 'dataResponse', 'resultYears', 'years'));
    }

    public function showDetailPerType(Request $request)
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getAll(
            $this->endpoint . '/total_accreditations_per_year',
            ['category' => $request->type],
            ['Authorization' => "Bearer " . $token]
        );

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        $type = $request->type;

        return view('admin.report.library-type.in-year.show-type-year', compact('fetchData', 'type'));
    }

    public function provinceByYear(Request $request)
    {
        if ($request->get('export') && $request->get('year')) {
            $today = now()->format('Ymd');
            return $this->export(
                $this->endpoint . '/total_accreditations_by_province_per_year',
                $today . " - Report Jumlah Akreditasi Berdasarkan Provinsi Per Tahun {$request->get('year')}.xlsx",
                ['year' => $request->get('year')]
            );
        }

        $year = $request->year ?? date('Y');

        $token = session('token.data.access_token');
        $fetchData = $this->admin->getAll($this->endpoint . '/total_accreditations_by_province_per_year', ['year' => $year], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        return view('admin.report.provinsi.index', compact('year', 'fetchData'));
    }

    public function reportByTypeByYear(Request $request)
    {
        if ($request->get('export') && $request->get('year')) {
            $today = now()->format('Ymd');
            return $this->export(
                $this->endpoint . '/total_accreditations_by_year',
                $today . " - Report Jumlah Akreditasi Berdasarkan Jenis Perpustakaan Dalam Tahun {$request->get('year')}.xlsx",
                ['year' => $request->get('year')]
            );
        }
        $year = $request->year ?? date('Y');

        $token = session('token.data.access_token');
        $fetchData = $this->admin->getAll($this->endpoint . '/total_accreditations_by_year', ['year' => $year], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        return view('admin.report.library-type.index-by-year', compact('fetchData', 'year'));
    }

    public function reportByProvinceInYear(Request $request)
    {
        if ($request->get('export')) {
            $today = now()->format('Ymd');
            return $this->export(
                $this->endpoint . '/total_accreditations_by_province_in_year',
                $today . " - Report Jumlah Akreditasi Berdasarkan Provinsi Dalam Tahun.xlsx"
            );
        }

        $token = session('token.data.access_token');
        $fetchData = $this->admin->getAll($this->endpoint . '/total_accreditations_by_province_in_year', [], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        $years = [];
        foreach ($fetchData['data']['per_provinces'] as $key => $value) {
            foreach ($value as $key2 => $value2) {
                if ($key2 != "name" && $key2 != "total") {
                    $years[] = $key2;
                }
            }
        }

        $years = array_unique($years);

        return view('admin.report.provinsi.in-year.index', compact('years', 'fetchData'));
    }

    public function reportLibraryTypeLatest(Request $request)
    {
        if ($request->get('export')) {
            $today = now()->format('Ymd');
            return $this->export($this->endpoint . '/total_accredited_libraries', $today . ' - Report Jumlah Perpustakaan Terakreditasi Berdasarkan Jenis Perpustakaan Hari ini.xlsx');
        }

        $token = session('token.data.access_token');
        $fetchData = $this->admin->getAll($this->endpoint . '/total_accredited_libraries', [], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        return view('admin.report.library-type.latest', compact('fetchData'));
    }

    public function reportLibraryTerakreditasiInYear(Request $request)
    {
        if ($request->get('export')) {
            $today = now()->format('Ymd');
            return $this->export(
                $this->endpoint . '/total_accredited_libraries_within_year',
                $today . " - Report Jumlah Perpustakaan Terakreditasi Berdasarkan Jenis Perpustakaan Dalam Tahun.xlsx"
            );
        }

        $token = session('token.data.access_token');
        $fetchData = $this->admin->getAll($this->endpoint . '/total_accredited_libraries_within_year', [], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        $years = [];
        foreach ($fetchData['data']['year_data'] as $key => $value) {
            foreach ($value as $key2 => $value2) {
                if ($key2 != "category" && $key2 != "total") {
                    $years[] = $key2;
                }
            }
        }

        $years = array_unique($years);        

        return view('admin.report.library-type.terakreditasi.index', compact('years', 'fetchData'));
    }

    public function reportTerakreditasiByProvinceInYear(Request $request)
    {
        if ($request->get('export')) {
            $today = now()->format('Ymd');
            return $this->export(
                $this->endpoint . '/total_accredited_libraries_by_provinces_in_year',
                $today . " - Report Jumlah Perpustakaan Terakreditasi Berdasarkan Provinsi Dalam Tahun.xlsx"
            );
        }

        $token = session('token.data.access_token');
        $fetchData = $this->admin->getAll($this->endpoint . '/total_accredited_libraries_by_provinces_in_year', [], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        $years = [];
        foreach ($fetchData['data']['provinces'] as $key => $value) {
            foreach ($value as $key2 => $value2) {
                if ($key2 != 'name') {
                    $years[] = $key2;
                }
            }
        }

        $years = array_unique($years);

        return view('admin.report.provinsi.terakreditasi.index', compact('years', 'fetchData'));
    }

    public function reportLibraryTerakreditasiInYearDetail(Request $request)
    {
        $token = session('token.data.access_token');
        $fetchData = $this->admin->getAll($this->endpoint . '/total_accredited_libraries_within_year', ['category' => $request->category], [
            'Authorization' => "Bearer " . $token
        ]);

        if (isset($fetchData['code']) && $fetchData['code'] == 'ERR4001') {
            return redirect()->route('logout');
        }

        $years = [];
        foreach ($fetchData['data']['detail'] as $key => $value) {
            foreach ($value as $key2 => $value2) {
                if ($key2 != 'category') {
                    $years[] = $key2;
                }
            }
        }

        $category = $request->category;
        $years = array_unique($years);

        return view('admin.report.library-type.terakreditasi.show', compact('fetchData', 'years', 'category'));
    }

    private function export($endpoint, $filename, $args = [])
    {
        $querystr = http_build_query(array_merge(['export' => 1], $args));
        $token = session('token.data.access_token');
        $file = $this->admin->downloadFile($endpoint.'?'.$querystr, [
            'Authorization' => "Bearer " . $token
        ]);

        if ($this->admin->getResponse()->getStatusCode() !== 200) {
            abort($this->admin->getResponse()->getStatusCode());
        }

        $name = \Str::random(32) . '.xlsx';
        $path = storage_path($name);
        file_put_contents($path, $file);

        return response()->download($path, $filename)->deleteFileAfterSend(true);
    }
}
