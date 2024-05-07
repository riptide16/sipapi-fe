<div class="row">
    <div class="col-12 col-sm-6 col-xl-6 mb-4">
        <div class="card border-0 shadow mb-4">
            <div class="card-header d-flex flex-row align-items-center flex-0 border-bottom">
                <div class="d-block">
                    <div class="h6 fw-bold text-gray mb-2">Hasil Akreditasi Terbaru</div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Kode Pengajuan</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Predikat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($latesAcreditation as $item)
                                <tr>
                                    <td>{{ $item['code'] }}</td>
                                    <td>{{ date('d/M/Y H:i', strtotime($item['created_at'])) }}</td>
                                    <td>{{ $item['predicate'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">Tidak ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-6 mb-4">
        <div class="card border-0 shadow mb-4">
            <div class="card-header d-flex flex-row align-items-center flex-0 border-bottom">
                <div class="d-block">
                    <div class="h6 fw-bold text-gray mb-2">Pengajuan Akreditasi Terbaru</div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Kode Pengajuan</th>
                                <th>Status</th>
                                <th>Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($submittedAccreditations as $item)
                                <tr>
                                    <td>{{ $item['code'] }}</td>
                                    <td>{{ $item['status'] }}</td>
                                    <td>{{ date('d/M/Y H:i', strtotime($item['updated_at'])) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">Tidak ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-xl-6">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="chart_period"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-4">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-header">
                        <h2 class="card-text">Jumlah Pengajuan Akreditasi</h2>
                    </div>
                    <div class="card-body">
                        <center>
                            <h2 class="total_acreditation"></h2>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        let url = "{{ route('admin.dashboard.get_chart_asesi') }}";
        $(function () {
            $.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                dataSrc: "data",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (data) {
                    if (data.perPeriods.length > 0) {
                        LoadChart(data.perPeriods)
                    }

                    $('.total_acreditation').text(data.totalPeriod)
                }
            })

        });

        function LoadChart(series) {
            var options = {
                chart: {
                    height: 'auto',
                    type: 'bar',
                },
                dataLabels: {
                    enabled: false
                },
                series: [
                    {
                        data: series
                    }
                ],
                title: {
                    text: 'Jumlah Perpustakaan Per Status',
                },
                noData: {
                    text: 'Loading...'
                }
            }

            var chart = new ApexCharts(
                document.querySelector(".chart_period"),
                options
            );
            chart.render();
        }
    </script>
@endpush