@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <x-icons.home/>
                    </a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    <a href="{{ route('admin.akreditasi.index') }}" class="text-info">
                        All Akreditasi
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Nilai Akhir Akreditasi</li>
            </ol>
        </nav>
        <h2 class="h4">Nilai Akhir Akreditasi Perpustakaan</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-centered table-nowrap mb-0 rounded">
                <thead class="thead-light">
                    <tr>
                        <th>No.</th>
                        <th>Komponen</th>
                        <th>Jumlah Skor</th>
                        <th>Jumlah Soal</th>
                        <th>Bobot</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $index = 1;
                    @endphp
                    @foreach ($result['data']['results'] as $item)
                        <tr>
                            <td class="border-bottom-1 rounded-start">{{ $index }}</td>
                            <td class="border-bottom-1">{{ $item['instrument_component'] }}</td>
                            <td class="border-bottom-1">{{ round($item['total_value'],2) }}</td>
                            <td class="border-bottom-1">{{ round($item['total_instrument'],2) }}</td>
                            <td class="border-bottom-1">{{ round($item['weight'],2) }}</td>
                            <td class="border-bottom-1">{{ round($item['score'],2) }}</td>
                        </tr>
                        @php
                            $index++;
                        @endphp
                    @endforeach
                </tbody>
                <tfoot class="bg-dark text-white">
                    <tr>
                        <td colspan="2"><b>Jumlah</b></td>
                        <td><b>{{ round($result['data']['finalResult']['total_value'],2) }}</b></td>
                        <td><b>{{ round($result['data']['finalResult']['total_instrument'],2) }}</b></td>
                        <td><b>{{ round($result['data']['finalResult']['weight'],2) }}</b></td>
                        <td><b>{{ round($result['data']['finalResult']['score'],2) }}</b></td>
                    </tr>
                </tfoot>
            </table>
            <div class="form-group row mt-2 mb-2">
                <div class="col-md-12">
                    <button id="btn-finalize" class="btn btn-info">Submit</button>
                    <x-buttons.cancel :href="route('admin.akreditasi.create')"/>
                </div>
            </div>
        </div>
    </div>
</div>
@endSection

@push('js')
    <script>
        $(document).ready(function () {
            $('#btn-finalize').click(function () {
                let id = "{{ $result['data']['id'] }}";
                let formData = new FormData();
                Swal.fire({
                    title : "",
                    text : "{{ __('Apakah Anda yakin untuk submit data ini?') }}",
                    icon : "info",
                    showCancelButton: true,					
                    confirmButtonText: "Konfirmasi",
                    cancelButtonText: "Batal",
                }).then((event) => {
                    if (event.isConfirmed) {
                        Swal.fire({
                            title : "",
                            text : "Harap Tunggu",
                            icon : "info",
                            showCancelButton: false,
                            showConfirmButton : false,
                            allowEscapeKey:false,
                            allowOutsideClick: false
                        });

                        formData.append('is_finalized', 1);

                        jQuery.ajax({
                            url: "{{ url('admin/finalize') }}/"+id,
                            type: 'POST',
                            cache: false,
                            data: formData,
                            contentType: false,
                            processData: false,
                            headers : {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                            success: (data) => {
                                if (data.status == 'success') {
                                    Swal.fire({
                                        title: "Sukses",
                                        text: data.message,
                                        icon: "success",
                                        showConfirmButton: false,
                                        showCancelButton: true,					
                                        cancelButtonText: "Close"
                                    }).then((event) => {
                                        if (event.dismiss === Swal.DismissReason.cancel) {
                                            window.location.href="{{ route('admin.akreditasi.index') }}"
                                        }
                                    })
                                } else {
                                    Swal.fire({
                                        title: "Warning",
                                        text: data.message,
                                        icon: "warning",
                                        showConfirmButton: false,
                                        showCancelButton: true,					
                                        cancelButtonText: "Close"
                                    }).then((event) => {
                                        if (event.dismiss === Swal.DismissReason.cancel) {
                                            location.reload();
                                        }
                                    });
                                }
                            }
                        })
                    } else if (event.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire('Cancelled', 'Submit Cancelled', 'warning');
                    }
                })
            })
        })
    </script>
@endpush
