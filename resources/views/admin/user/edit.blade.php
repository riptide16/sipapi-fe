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
                    <a href="{{ route('admin.user.index') }}" class="text-info">
                        All Users
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit User</li>
            </ol>
        </nav>
        <h2 class="h4">Edit Data User</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.user.update', ['id' => $user['id']]) }}" method="POST">
            @csrf
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Name')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="name" value="{{ $user['name'] }}" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('E-mail')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="email" value="{{ $user['email'] }}" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Username')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.input name="username" value="{{ $user['username'] }}" disabled/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Role')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.select-role name="role_id" :placeholder="__('Role User')" :fill="$user['role']['id']" required/>
                </div>
            </div>
            <div class="form-group {{ ($user['role']['name'] != 'admin' || $user['role']['name'] != 'super_admin') ? 'd-none' : '' }} row mb-2" id="field-wilayah">
                <div class="col-md-3">
                    <x-forms.label :label="__('Wilayah')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.select-region name="region_id" :placeholder="__('Wilayah')" :fill="$user['region']['id'] ?? __('')"/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Status User')"/>
                </div>
                <div class="col-md-9">
                    <x-forms.select-status-user name="status" :placeholder="__('Role User')" :fill="$user['status']" required/>
                </div>
            </div>
            <div class="form-group row text-center">
                <div class="col-md-12">
                    <x-buttons.save :title="__('Update User')"/>
                    <x-buttons.cancel :href="route('admin.user.index')"/>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $('#role_id').change(function () {
                if ($(this).val() == '9435048f-5489-41c0-9b19-0dcf334b328b' || $(this).val() == '9435048f-5a3f-4c5c-8d7d-1a189e0c75a5') {
                    $('#field-wilayah').removeClass('d-none');
                } else {
                    $('#field-wilayah').addClass('d-none');
                }
            })
        })
    </script>
@endpush