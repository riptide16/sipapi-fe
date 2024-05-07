@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Akreditasi</li>
            </ol>
        </nav>
        <h2 class="h4">Data Akreditasi</h2>
        @if (\Helper::isAsesi())
            <x-accreditation-actions />
        @endif
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <!-- <div style="margin-bottom: 10px">
                Toggle column: 
                <a class="toggle-vis" data-column="1">Kode Pengajuan</a> <br> <a class="toggle-vis" data-column="2">NPP</a> - <a class="toggle-vis" data-column="3">Lembaga Induk</a> - <a class="toggle-vis" data-column="4">Nama Perpustakaan</a> - <a class="toggle-vis" data-column="5">Jenis Perpustakaan</a> - <a class="toggle-vis" data-column="6">Wilayah</a>
            </div> -->
            <table id="datatable" class="table table-centered table-nowrap mb-0 rounded">
                <thead class="thead-light">
                    <tr>
                        <th class="border-0 rounded-start">No</th>
                        <th class="border-0">Kode Pengajuan</th>
                        <th class="border-0">NPP</th>
                        <th class="border-0" wrap>Lembaga Induk</th>
                        <th class="border-0" wrap>Nama Perpustakaan</th>
                        <th class="border-0">Jenis Perpustakaan</th>
                        <th class="border-0">Wilayah</th>
                        <th class="border-0">Provinsi</th>
                        <th class="border-0">Kab./Kota</th>
                        <th class="border-0">Kecamatan</th>
                        <th class="border-0">Alamat</th>
                        <th class="border-0">Tanggal Ajuan</th>
                        <th class="border-0">Status</th>
                        <th class="border-0">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                    @endphp
                    @forelse ($fetchData['data'] as $data)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $data['code'] }}</td>
                            <td>{{ $data['institution']['npp'] }}</td>
                            <td ><a href="{{ route('admin.data_kelembagaan.show', $data['institution']['id']) }}">{{ $data['institution']['agency_name'] }}</a></td>
                            <td>{{ $data['institution']['library_name'] }}</td>
                            <td>{{ $data['institution']['category'] }}</td>
                            <td>{{ $data['institution']['region']['name'] }}</td>
                            <td>{{ $data['institution']['province']['name'] }}</td>
                            <td>{{ $data['institution']['city']['type'] }} {{ $data['institution']['city']['name'] }}</td>
                            <td>{{ $data['institution']['subdistrict']['name'] }}</td>
                            <td>{{ $data['institution']['address'] }}</td>
                            <td>{{ \Helper::formatDate($data['created_at'], 'Y-m-d') }}</td>
                            <td>{{ \Helper::titlize($data['appealed_at'] ? 'banding' : $data['status']) }}</td>
                            <!-- <td>{{ \Helper::titlize($data['appealed_at'] ? 'banding' : $data['status']) }}</td> -->
                            <td>
                                @include('components.general-actions-resource', [
                                    'route' => 'admin.akreditasi',
                                    'id' => $data['id'],
                                    'model' => 'akreditasi',
                                    'status' => $data['status'],
                                    'actions' => [
                                        'show' => true,
                                        'edit' => \Helper::isAsesi() && $data['status'] === 'belum_lengkap',
                                    ],
                                    'args' => [
                                        'type' => $data['type'],
                                    ],
                                ])
                            </td>
                        </tr>
                        @php $i++; @endphp
                    @empty
                        <tr>
                            <td colspan="5">No Have Match Data in Table</td>
                        </tr>
                    @endforelse
                </tbody>
                <!-- <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="border-0">Jenis Perpustakaan</th>
                        <th class="border-0">Wilayah</th>
                        <th class="border-0">Provinsi</th>
                        <th class="border-0">Kab./Kota</th>
                        <th class="border-0">Kecamatan</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot> -->
            </table>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script>
        const table = $('#datatable').DataTable({
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
            },
            select: true,
            order: [[0, "asc"]],
            autoWidth: false,
            lengthMenu: [10,20,50,75,100],
            drawCallback: function() {
                $.getScript('/admin/js/jquery.sweet-alert.js');
            },
            initComplete: function () {
                this.api()
                    .columns([5,6,7,8,9])
                    .every(function () {
                        let column = this;
        
                        // Create select element
                        let select = document.createElement('select');
                        select.add(new Option(''));
                        column.footer().replaceChildren(select);
        
                        // Apply listener for user change in value
                        select.addEventListener('change', function () {
                            var val = DataTable.util.escapeRegex(select.value);
        
                            column
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });
        
                        // Add list of options
                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.add(new Option(d));
                            });
                    });
            }
        });

        document.querySelectorAll('a.toggle-vis').forEach((el) => {
            el.addEventListener('click', function (e) {
                e.preventDefault();
        
                let columnIdx = e.target.getAttribute('data-column');
                let column = table.column(columnIdx);
        
                // Toggle the visibility
                column.visible(!column.visible());
            });
        });
    </script>
@endpush
