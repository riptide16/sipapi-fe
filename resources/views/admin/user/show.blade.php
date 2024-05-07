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
                <li class="breadcrumb-item active" aria-current="page">View User</li>
            </ol>
        </nav>
        <h2 class="h4">View Data User</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <div class="form-group mb-2">
            <div class="col-md-3">
                <x-forms.label :label="__('Name :')"/>
            </div>
            <div class="col-md-9">
                <x-forms.label class="text-info" :label="$user['name']"/>
            </div>
        </div>
        <div class="form-group mb-2">
            <div class="col-md-3">
                <x-forms.label :label="__('Username :')"/>
            </div>
            <div class="col-md-9">
                <x-forms.label class="text-info" :label="$user['username']"/>
            </div>
        </div>
        <div class="form-group mb-2">
            <div class="col-md-3">
                <x-forms.label :label="__('E-mail :')"/>
            </div>
            <div class="col-md-9">
                <x-forms.label class="text-info" :label="$user['email']"/>
            </div>
        </div>
        @if($user['role']['name'] != "asesi" || $user['role']['name'] != "asesor")
        <div class="form-group mb-2">
            <div class="col-md-3">
                <x-forms.label :label="__('Role :')"/>
            </div>
            <div class="col-md-9">
                <x-forms.label class="text-info" :label="$user['role']['display_name']"/>
            </div>
        </div>
        @endif
        @if($user['role']['name'] == "admin" || $user['role']['name'] == "super_admin")
        <div class="form-group mb-2">
            <div class="col-md-3">
                <x-forms.label :label="__('Wilayah :')"/>
            </div>
            <div class="col-md-9">
                <x-forms.label class="text-info" :label="$user['region']['name'] ?? __('-')"/>
            </div>
        </div>
        @endif
        <div class="form-group mb-2">
            <div class="col-md-3">
                <x-forms.label :label="__('Photo :')"/>
            </div>
            <div class="col-md-9">
                @if(!empty($user['profile_picture']))
                <img src="{{ $user['profile_picture'] }}" alt="profile" class="img-responsive">
                @else
                -
                @endif
            </div>
        </div>
        <div class="form-group mb-2">
            <div class="col-md-3">
                <x-forms.label :label="__('Status User :')"/>
            </div>
            <div class="col-md-9">
                <x-forms.label class="text-info" :label="$user['status_text']"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <x-buttons.back :href="route('admin.user.index')"/>
            </div>
        </div>
    </div>
</div>
@endsection
