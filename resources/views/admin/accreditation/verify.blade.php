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
                <li class="breadcrumb-item active" aria-current="page">Verifikasi Akreditasi</li>
            </ol>
        </nav>
        <h2 class="h4">Verifikasi Data Akreditasi</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.akreditasi.verify.post', [$fetchData['id']]) }}" method="POST">
            @csrf
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Kode Pengajuan')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.label class="text-info" :label="$fetchData['code']"/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Nama Perpustakaan')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.label class="text-info" :label="$fetchData['institution']['library_name']"/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Tanggal Ajuan')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.label class="text-info" :label="\Helper::formatDate($fetchData['created_at'], 'd F Y')"/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Jenis Perpustakaan')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.label class="text-info" :label="$fetchData['institution']['category'] ?? '-'"/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Nama Instansi')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.label class="text-info" :label="$fetchData['institution']['agency_name'] ?? '-'"/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3 required">
                    <x-forms.label :label="__('Data Pengajuan')"/>
                </div>
                <div class="col-md-9">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_approved" id="ajuan_1" value="1"  @if($readOnly) disabled checked @endif>
                        <label class="form-check-label" for="ajuan_1">Data Pengajuan Lengkap</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_approved" id="ajuan_2" value="0"  @if($readOnly) disabled @endif>
                        <label class="form-check-label" for="ajuan_2">Data Pengajuan Belum Lengkap</label>
                    </div>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Catatan')"/>
                </div>
                <div class="col-md-9">
                    <textarea name="notes" class="form-control" cols="5" rows="2" @if($readOnly) disabled @endif>{{ $fetchData['notes'] ?? '' }}</textarea>
                </div>
            </div>
            <div class="data-fulfilled {{ empty($fetchData['assignments']) ? 'd-none' : '' }}">
                <div class="form-group row mb-2">
                    <div class="col-md-3 required">
                        <x-forms.label :label="__('Asesor 1')"/>
                    </div>
                    <div class="col-md-9">
                        @if($readOnly)
                        <x-forms.label :label="$fetchData['assignments'][0]['assessors'][0]['name'] ?? '-'" />
                        @else
                        <x-forms.select-asesor name="asesor_1" :province="__($fetchData['institution']['province']['id'])" :fill="__('')" :placeholder="__('Select Asesor 1')"/>
                        @endif
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <div class="col-md-3">
                        <x-forms.label :label="__('Asesor 2')"/>
                    </div>
                    <div class="col-md-9">
                        @if($readOnly)
                        <x-forms.label :label="$fetchData['assignments'][0]['assessors'][1]['name'] ?? '-'" />
                        @else
                        <x-forms.select-asesor name="asesor_2" :province="__($fetchData['institution']['province']['id'])" :fill="__('')" :placeholder="__('Select Asesor 2')"/>
                        @endif
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <div class="col-md-3">
                        <x-forms.label :label="__('Asesor 3')"/>
                    </div>
                    <div class="col-md-9">
                        @if($readOnly)
                        <x-forms.label :label="$fetchData['assignments'][0]['assessors'][2]['name'] ?? '-'" />
                        @else
                        <x-forms.select-asesor name="asesor_3" :province="__($fetchData['institution']['province']['id'])" :fill="__('')" :placeholder="__('Select Asesor 3')"/>
                        @endif
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <div class="col-md-3 required">
                        <x-forms.label :label="__('Jadwal')"/>
                    </div>
                    <div class="col-md-9">
                        @if($readOnly)
                        <x-forms.label :label="isset($fetchData['assignments'][0]['scheduled_date']) ? \Helper::formatDate($fetchData['assignments'][0]['scheduled_date'], 'd F Y') : '-'" />
                        @else
                        <x-forms.input type="date" name="scheduled_date" />
                        @endif
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <div class="col-md-3">
                        <x-forms.label :label="__('Metode Penilaian')"/>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group row">
                            @if ($readOnly)
                                <x-forms.label :label="$fetchData['assignments'][0]['method'] ?? '-'" />
                            @else
                            <div class="col-md-2">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline1" value="Online" name="method" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadioInline1">Online</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline2" value="Onsite" name="method" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadioInline2">On Site</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline2" value="Portofolio" name="method" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadioInline2">Portofolio</label>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row text-center">
                <div class="col-md-12">
                    @if (!$readOnly)
                        <x-buttons.save :title="__('Verifikasi')"/>
                    @endif
                    <x-buttons.cancel :href="route('admin.akreditasi.index')"/>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $('input[name="is_approved"]').change(function () {
                if ($(this).val() == 1) {
                    $('.data-fulfilled').removeClass('d-none')
                } else {
                    $('.data-fulfilled').addClass('d-none')
                }
            })
        })
    </script>
@endpush
