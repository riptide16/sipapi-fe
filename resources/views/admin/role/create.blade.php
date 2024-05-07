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
                    <a href="{{ route('admin.roles.index') }}" class="text-info">
                        All Roles
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Create Role</li>
            </ol>
        </nav>
        <h2 class="h4">Input Data Role</h2>
    </div>
</div>
<div class="card border-0 shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Display Name')"/>
                </div>
                <div class="col-md-9">
                    <input class="form-control" name="display_name" id="display_name" required/>
                </div>
            </div>
            <div class="form-group row mb-2">
                <div class="col-md-3">
                    <x-forms.label :label="__('Name')"/>
                </div>
                <div class="col-md-9">
                    <input class="form-control" name="name" id="name" required/>
                </div>                
            </div>
            <div class="form-group row text-center">
                <div class="col-md-12">
                    <x-buttons.save :title="__('Save Role')"/>
                    <x-buttons.cancel :href="route('admin.roles.index')"/>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
    <script>
        $(document).ready(function(){
            $("#display_name").keypress(function(){
                var display_name = $("#display_name").val();
                var strReplace = display_name.replace(" ", "_");
                $("#name").val(strReplace.toLowerCase());
            });
        });
    </script>
@endpush
