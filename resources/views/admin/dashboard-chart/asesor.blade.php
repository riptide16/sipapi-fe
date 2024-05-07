<div class="row">
    <div class="col-12 col-sm-6 col-xl-6 mb-4">
        <div class="card border-0 shadow mb-4">
            <div class="card-header d-flex flex-row align-items-center flex-0 border-bottom">
                <div class="d-block">
                    <div class="h6 fw-bold text-gray mb-2">Jadwal Penilaian Terbaru</div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Kode Pengajuan</th>
                                <th>Jadwal Penilaian</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($submittedAccreditations as $item)
                                <tr>
                                    <td>{{ $item['accreditation']['code'] }}</td>
                                    <td>{{ date('d/M/Y H:i', strtotime($item['scheduled_date'])) }}</td>
                                    <td>{{ $item['accreditation']['status'] }}</td>
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
                    <div class="h6 fw-bold text-gray mb-2">Jumlah Penilaian Akreditasi</div>
                </div>
            </div>
            <div class="card-body">
                <center>
                    <h2 class="total_acreditation"></h2>
                </center>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        let url = "{{ route('admin.dashboard.get_chart_asesor') }}";
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
                    $('.total_acreditation').text(data.totalPeriod)
                }
            })

        });
    </script>
@endpush