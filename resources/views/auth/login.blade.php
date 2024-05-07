@extends('layouts.app')

@section('content')
<main>
    <section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center form-bg-image" data-background="{{ asset('admin/assets/img/illustrations/signin.svg') }}">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                        <div class="text-center text-md-center mb-4 mt-md-0">
                            <h1 class="mb-0 h3">Sign in to our platform</h1>
                        </div>
                        <form action="{{ config('APP_URL') }}/login/store" class="mt-4" method="POST">
                            @csrf
                            <div class="form-group mb-4">
                                <x-forms.label :label="__('Your Username')"/>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">
                                        <x-icons.mail/>
                                    </span>
                                    <x-forms.input-group name="username" placeholder="Username" required autofocus/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group mb-4">
                                    <x-forms.label :label="__('Your Password')"/>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon2">
                                            <x-icons.lock/>
                                        </span>
                                        <x-forms.input-group name="password" type="password" placeholder="Password" required/>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-top mb-4">
                                    <div class="form-check">
                                        <x-forms.checkbox name="remember"/>
                                    </div>
                                    <div>
                                        <a href="{{ route('forgot_password.index') }}" class="small text-right">Lost password?</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid">
                                <x-buttons.save :title="__('Sign In')"/>
                            </div>
                        </form>
                        {{-- dikomen sementara --}}
                        {{-- <div class="mt-3 mb-4 text-center">
                            <span class="fw-normal">or login with</span>
                        </div>
                        <div class="d-flex justify-content-center align-items-center mt-4">
                            <a href="#" class="btn btn-icon-only btn-pill btn-danger"
                                aria-label="google button" title="google button">
                                <x-icons.google/>
                            </a>
                        </div> --}}
                        <div class="d-flex justify-content-center align-items-center mt-4">
                            <span class="fw-normal">
                                Not registered?
                                <a href="{{ route('register.index') }}" class="fw-bold">Create account</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
