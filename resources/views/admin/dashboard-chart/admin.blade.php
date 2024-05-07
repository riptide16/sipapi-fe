<div class="row">
    <div class="col-12 col-sm-6 col-xl-6 mb-4">
        <div class="card border-0 shadow mb-4">
            <div class="card-body">
                <div class="category_chart"></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-6 mb-4">
        <div class="card border-0 shadow mb-4">
            <div class="card-body">
                <div class="status_chart"></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-12 mb-4">
        <div class="card border-0 shadow mb-4">
            <div class="card-header d-flex flex-row align-items-center flex-0 border-bottom">
                <div class="d-block">
                    <div class="h6 fw-bold text-gray mb-2">Status Penilaian Akreditasi Terbaru</div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th>Kode Pengajuan</th>
                                <th>Tanggal Ajuan</th>
                                <th>Status</th>
                                <th>Tanggal Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latesAcreditation as $key => $value)
                                <tr>
                                    <td>{{ $value['code'] }}</td>
                                    <td>{{ date('d/M/Y H:i', strtotime($value['created_at'])) }}</td>
                                    <td>{{ $value['status'] }}</td>
                                    <td>{{ date('d/M/Y H:i', strtotime($value['updated_at'])) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-xl-8">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-header">
                        <h2 class="card-text">Jumlah Perpustakaan Per Predikat</h2>
                    </div>
                    <div class="card-body">
                        <div class="pie"></div>
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
                        <h2 class="card-text">Jumlah Penilaian Akreditasi</h2>
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
        let url = "{{ route('admin.dashboard.get_chart_admin') }}";
        $(function () {
            var options1 = {
                chart: {
                    height: 'auto',
                    type: 'bar',
                },
                dataLabels: {
                    enabled: false
                },
                series: [],
                title: {
                    text: 'Jumlah Perpustakaan Per Jenis',
                },
                noData: {
                    text: 'Loading...'
                }
            }

            var chart1 = new ApexCharts(
                document.querySelector(".category_chart"),
                options1
            );
            chart1.render();

            $.getJSON(url, function(response) {
                chart1.updateSeries([{
                    name: 'Total Jenis',
                    data: response.categories
                }])
            });

            var options2 = {
                chart: {
                    height: 'auto',
                    type: 'bar',
                },
                dataLabels: {
                    enabled: false
                },
                series: [],
                title: {
                    text: 'Jumlah Perpustakaan Per Status',
                },
                noData: {
                    text: 'Loading...'
                }
            }

            var chart2 = new ApexCharts(
                document.querySelector(".status_chart"),
                options2
            );
            chart2.render();

            $.getJSON(url, function(response) {
                chart2.updateSeries([{
                    name: 'Total Status',
                    data: response.statuses
                }])
            });

            $.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                dataSrc: "data",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (data) {
                    if (data.predicates.length > 0) {
                        LoadChart(data.predicates, data.labels)
                    }

                    $('.total_acreditation').text(data.total_accreditations)
                }
            })

        });

        function LoadChart(series, labels) {
            // Donut Chart
            var donutChart = {
                chart: {
                    height: 350,
                    type: 'donut',
                    toolbar: {
                        show: false,
                    }
                },
                dataLabels: {
                    formatter(val, opts) {
                        const name = opts.w.globals.labels[opts.seriesIndex]
                        return [name, val.toFixed(1) + "%"]
                    }
                },
                series: series,
                labels: labels,
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 305
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            }
            var donut = new ApexCharts(
                document.querySelector(".pie"),
                donutChart
            );
            donut.render();
        }
    </script>
@endpush